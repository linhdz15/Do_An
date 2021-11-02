import React, {Component} from 'react';
import PropTypes from 'prop-types';
import {SortableContainer, SortableElement, arrayMove} from 'react-sortable-hoc';
import QuestionList from './QuestionList';
import QuestionForm from './QuestionForm';
import CurriculumForm from './CurriculumForm';

class Curriculum extends Component {
    constructor(props) {
        super(props);

        this.state = {
            curriculums: [],
            curriculum: {},
            curriculumIndex: NaN,
            questions: [],
            question: {},
            isNewQuestion: true,
            showListQuestion: false,
            openQuestionForm: false,
            openCurriculumForm: false,
            isCurriculumParent: false,
            isNewCurriculum: true,
        }
    }

    static childContextTypes = {
        handleSubmitQuestion: PropTypes.func.isRequired,
        handleSubmitCurriculum: PropTypes.func.isRequired,
    };

    getChildContext() {
        return {
            handleSubmitQuestion: (question) => this.handleSubmitQuestion(question),
            handleSubmitCurriculum: (curriculum) => this.handleSubmitCurriculum(curriculum),
        };
    }

    /**
     * Set course_id while component mount
     * and fetch curriculum item data from service
     */
    componentDidMount() {
        axios.get('curriculums').then((response) => {
            if (response.status === 200) {
                this.setState({
                    curriculums: response.data.curriculums
                })
            }
        })
    }

    onSortCurriculums = ({oldIndex, newIndex}) => {
        let {curriculums} = this.state;
        curriculums = arrayMove(curriculums, oldIndex, newIndex);

        axios.post('sort-curriculums', {curriculums}).then((response) => {
            if (response.status === 200) {
                this.setState({curriculums});
            }
        })
    };

    onSortQuestions = ({oldIndex, newIndex}) => {
        let {questions} = this.state;
        questions = arrayMove(questions, oldIndex, newIndex);

        axios.post('sort-questions', {questions}).then((response) => {
            if (response.status === 200) {
                this.setState({questions});
            }
        })
    };

    getListQuestions = (curriculum, showQuestions) => {
        let {curriculums, questions, curriculumIndex} = this.state;
        const index = _.findIndex(curriculums, ['id', curriculum.id]);

        if (curriculumIndex == index) {
            this.setState({curriculumIndex: null, openQuestionForm: false, showListQuestion: false})
        } else {
            axios.get(`curriculums/${curriculum.id}/questions`).then((response) => {
                if (response.status === 200) {
                    questions = response.data.questions;

                    this.setState({
                        questions,
                        curriculumIndex: index,
                        showListQuestion: true,
                        openQuestionForm: false
                    })
                }
            })
        }
    }

    handleEditQuestion = (question) => {
        this.setState({
            openQuestionForm: true,
            isNewQuestion: false,
            question
        });
    }

    handleDelQuestion = (question) => {
        var r = confirm(`Xóa câu hỏi này: ${question.title}!`);

        if (r == true) {
            let {questions} = this.state;
            const questionIndex = _.findIndex(questions, ['id', question.id]);

            axios.delete(`questions/${question.id}`).then((response) => {
                if (response.status === 200) {
                    questions.splice(questionIndex, 1);
                    this.setState({questions})
                }
            })
        }
    }

    toggleQuestionForm = (openQuestionForm) => {
        this.setState({
            openQuestionForm,
            isNewQuestion: true,
            question: {}
        });
    }

    toggleCurriculumForm = (openCurriculumForm, isCurriculumParent = false) => {
        this.setState({
            openCurriculumForm,
            isCurriculumParent,
            isNewCurriculum: true,
            curriculum: {}
        });
    }

    handleEditCurriculum = (curriculum, isCurriculumParent = false) => {
        let {curriculums, curriculumIndex} = this.state;
        curriculumIndex = _.findIndex(curriculums, ['id', curriculum.id]);

        this.setState({
            openCurriculumForm: true,
            isNewCurriculum: false,
            curriculum,
            curriculumIndex,
            isCurriculumParent
        });
    }

    handleDelCurriculum= (curriculum) => {
        if (curriculum.questions_count > 0) {
            alert('Vui Lòng xóa các câu hỏi trong đề trước khi xóa đề!');

            return;
        }

        var r = confirm(`Xóa phần này: ${curriculum.title}!`);

        if (r == true) {
            let {curriculums} = this.state;
            const curriculumIndex = _.findIndex(curriculums, ['id', curriculum.id]);

            axios.delete(`curriculums/${curriculum.id}`).then((response) => {
                if (response.status === 200) {
                    curriculums.splice(curriculumIndex, 1);
                    this.setState({curriculums})
                }
            }).catch(function(error) {
                if (error.response && error.response.data && error.response.data.message) {
                    const msg = error.response.status === 419 ?
                        'Phiên làm việc trên form đã hết hạn. Vui lòng tải lại trang!' :
                        error.response.data.message;

                    alert(msg);
                } else {
                    window.location.reload();
                }
            })
        }
    }

    handleSubmitCurriculum = (curriculum) => {
        let { curriculums } = this.state;
        const curriculumIndex = _.findIndex(curriculums, ['id', curriculum.id]);

        if (curriculumIndex >= 0) {
            curriculums[curriculumIndex] = curriculum;
        } else {
            curriculums.push(curriculum);
        }

        this.setState({
            curriculums,
            openCurriculumForm: false,
            isCurriculumParent: false,
            isNewCurriculum: true,
            curriculum: {}
        });
    }

    handleSubmitQuestion = (question) => {
        let {questions} = this.state;
        const questionIndex = _.findIndex(questions, ['id', question.id]);

        if (questionIndex >= 0) {
            questions[questionIndex] = question;
        } else {
            questions.push(question);
        }

        this.setState({
            questions,
            openQuestionForm: false,
            isNewQuestion: true,
            question: {}
        })
    }

    render() {
        const {
            showQuestions,
            curriculumIndex,
            questions,
            openQuestionForm,
            isNewQuestion,
            question,
            showListQuestion,
            openCurriculumForm,
            isCurriculumParent,
            isNewCurriculum,
            curriculum
        } = this.state;

        let sectionIndex = 1;

        const SortableItem = SortableElement(({curriculum, sortIndex}) => {
            return (
                <div className={curriculum.parent_id ? 'curriculum-item curriculum-lecture' : 'curriculum-item'}>
                    <div className="section-editor">
                    {curriculumIndex === sortIndex && openCurriculumForm && !isNewCurriculum ?  (
                        <CurriculumForm
                            isNewCurriculum={isNewCurriculum}
                            isCurriculumParent={isCurriculumParent}
                            toggleCurriculumForm={this.toggleCurriculumForm}
                            curriculum={curriculum}
                        />
                    ) : (
                        <div className="item-bar">
                            <div className="item-bar-title">
                                <span className="item-bar-status">
                                    {(curriculum.status == 0) ? (
                                        <span>
                                            <i className="fa fa-exclamation-triangle" style={{color: '#f59c49'}}></i> Lưu nháp:
                                        </span>
                                    ): (
                                        <span>
                                            <i className="fa fa-check-circle" style={{color: '#007791', marginRight: '5px'}}></i>
                                        </span>
                                    )}
                                </span>
                                <span className="item-bar-name">
                                    {curriculum.parent_id ? (
                                        <span className="fa fa-check-square-o item-bar-name-icon"></span>
                                    ): (
                                        <span className="fa fa-file-text-o item-bar-name-icon"></span>
                                    )}
                                    <span>{curriculum.title}</span>
                                </span>

                                <button
                                    className="btn btn-xs item-bar-button"
                                    onClick={() => this.handleEditCurriculum(curriculum, curriculum.parent_id ? false : true)}
                                ><i className="fa-pencil fa"></i></button>

                                {this.props.hasrole && (
                                    <button
                                        className="btn btn-xs item-bar-button"
                                        onClick={() => this.handleDelCurriculum(curriculum)}
                                    ><i className="fa-trash-o fa"></i></button>
                                )}
                            </div>
                            <div>
                                {curriculum.parent_id && (
                                    <div className="item-bar-right">
                                        <button style={{marginTop: '5px'}} className="btn btn-xs item-bar-button item-bar-show" onClick={() => this.getListQuestions(curriculum, !this.state.showQuestions)}>
                                            <i style={{marginTop: '-2px'}} className="fa-chevron-down fa"></i>
                                            <span className={curriculum.questions_count > 0 ? 'text-primary' : 'text-danger'}> (<b>{ curriculum.questions_count }</b> câu hỏi)</span>
                                        </button>
                                    </div>
                                )}
                                <span className="btn btn-xs item-bar-button"><i className="fa-bars fa"></i></span>
                            </div>
                        </div>
                    )}
                    </div>
                    {curriculumIndex === sortIndex && (
                        openQuestionForm ? (
                            <QuestionForm
                                toggleQuestionForm={this.toggleQuestionForm}
                                isNewQuestion={isNewQuestion}
                                question={question}
                                curriculum={curriculum}
                            />
                        ) : (
                            showListQuestion && (
                                <QuestionList
                                    questions={questions}
                                    curriculum={curriculum}
                                    toggleQuestionForm={this.toggleQuestionForm}
                                    handleEditQuestion={this.handleEditQuestion}
                                    handleDelQuestion={this.handleDelQuestion}
                                    onSortQuestions={this.onSortQuestions}
                                    {...this.props}
                                />
                            )
                        )
                    )}
                </div>
            )
        });

        const SortableList = SortableContainer(({curriculums}) => {
            return (
                <div className="curriculum-list">
                    {curriculums.map((curriculum, index) => (
                        <SortableItem key={`item-${index}`} index={index} sortIndex={index} curriculum={curriculum} />
                    ))}
                </div>
            );
        });

        return (
            <div className="curriculum-editor">
                <SortableList
                    curriculums={this.state.curriculums}
                    onSortEnd={this.onSortCurriculums}
                    shouldCancelStart={(e) => {
                        if (e.target.className != 'fa-bars fa') {
                            return true; // Return true to cancel sorting
                        }
                    }}
                />
                { openCurriculumForm === true && isNewCurriculum ? (
                    <CurriculumForm
                        isNewCurriculum={isNewCurriculum}
                        isCurriculumParent={isCurriculumParent}
                        toggleCurriculumForm={this.toggleCurriculumForm}
                        curriculum={curriculum}
                    />
                ) : (
                    <div className="curriculum-control">
                        <div className="button-group">
                            <button
                                className="btn btn-outline-primary btn-100"
                                onClick={() => this.toggleCurriculumForm(true)}
                            >
                                <span className="fa fa-plus-square"></span> Thêm bài thi
                            </button>
                            <button
                                className="btn btn-outline-primary btn-100"
                                onClick={() => this.toggleCurriculumForm(true, true)}
                            >
                                <span className="fa fa-plus-square"></span> Thêm phần
                            </button>
                        </div>
                    </div>
                )}
            </div>
        )
    }
}

export default Curriculum;
