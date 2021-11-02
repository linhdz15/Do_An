import React, {Component} from 'react';
import {SortableContainer, SortableElement} from 'react-sortable-hoc';

class QuestionList extends Component {
    constructor(props) {
        super(props);
        this.state = {
            activeCurriculum: false,
        }
    }

    changeStatusCurriculum = (status) => {
        this.setState({activeCurriculum: status});
    }

    render() {
        const {curriculum, questions, toggleQuestionForm, handleEditQuestion, handleDelQuestion, onSortQuestions} = this.props;
        const { activeCurriculum } = this.state;

        const SortableItem = SortableElement(({question, sortIndex}) => {
            return (
                <div>
                    <div className="question-item-wrapper">
                        <div className="question-item" style={{display: 'block'}}>
                            <b>{sortIndex + 1}. </b>
                            <span dangerouslySetInnerHTML={{__html: question.content.replace(/(<? *script)/gi, 'illegalscript').replace(/<[^>]+>/g, '')}} ></span>
                            <p>
                                - Tiêu đề SEO: {question.title} <br/>
                                - Slug: <a href="" target="_blank">{question.slug}</a>
                            </p>
                        </div>
                        <div className="question-item-panel" style={{minWidth: '155px'}}>
                            <button className="btn btn-xs item-bar-button">
                                <i className="fa-bars fa"></i>
                            </button>
                            <button
                                className="btn btn-xs item-bar-button"
                                onClick={() => handleEditQuestion(question)}
                            ><i className="fa-pencil fa"></i></button>

                            {this.props.hasrole && (
                                <button
                                    className="btn btn-xs item-bar-button"
                                    onClick={() => handleDelQuestion(question)}
                                ><i className="fa-trash-o fa"></i></button>
                            )}
                        </div>
                    </div>
                </div>
            )
        })

        const SortableList = SortableContainer(({questions}) => {
            return (
                <div className="curriculum-list">
                    {questions.map((question, index) => (
                        <SortableItem key={`item-${index}`} index={index} sortIndex={index} question={question} />
                    ))}
                </div>
            );
        });

        return (
            <div className="lecture-add-more">
                <div className="lecture-content-container">
                    <div className="lecture-content-wrapper">
                        <div className="quiz-content">
                            Câu hỏi
                            <button
                                onClick={() => toggleQuestionForm(true)}
                            >Thêm câu hỏi mới</button>
                        </div>
                    </div>
                    {/*<div className="lecture-content-action">
                        {activeCurriculum ? (
                            <button
                                onClick={() => this.changeStatusCurriculum(false)}
                                className="btn btn-danger"
                            >Ngừng xuất bản</button>
                        ) : (
                            <button
                                onClick={() => this.changeStatusCurriculum(true)}
                                className="btn btn-info"
                            >Xuất bản</button>
                        )}
                    </div>*/}
                </div>

                <div className="question-list">
                    <SortableList
                        questions={questions}
                        onSortEnd={onSortQuestions}
                        shouldCancelStart={(e) => {
                            if (e.target.className != 'fa-bars fa') {
                                return true; // Return true to cancel sorting
                            }
                        }}
                    />
                </div>
            </div>
        )
    }
}

export default QuestionList;
