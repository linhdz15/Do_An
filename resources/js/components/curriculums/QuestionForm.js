import React, {Component} from 'react';
import PropTypes from 'prop-types';
import TinymceEditor from './TinymceEditor';
import ButtonSubmit from '../ButtonSubmit';

class QuestionForm extends Component {
    constructor(props) {
        super(props);
        this.state = {
            title: '',
            slug: '',
            content: '',
            reason: '',
            answers: [
                {content: ''},
                {content: ''},
                {content: ''},
                {content: ''},
            ],
            blankAnswer: {content: ''},
            checkAnswer: 0,
            isNewQuestion: true,
            isButtonLoading: false,
        }
    }

    static getDerivedStateFromProps(nextProps, prevState) {
        if(!nextProps.isNewQuestion && prevState.isNewQuestion !== nextProps.isNewQuestion) {
            const question = nextProps.question;
            let checkAnswer = 0;

            if (question.answers.length > 0) {
                checkAnswer = question.answers.findIndex(answer => answer.answer == 1);
            }

            return {
                title: question.title,
                slug: question.slug,
                content: question.content,
                reason: question.reason,
                answers: question.answers,
                checkAnswer: checkAnswer,
                isNewQuestion: nextProps.isNewQuestion,
                isButtonLoading: false,
            };
        }

        return null;
    }

    static contextTypes = {
        handleSubmitQuestion: PropTypes.func.isRequired,
    };

    addNewAnswer = () => {
        let { blankAnswer, answers } = this.state;
        let length = answers.length;

        if (length < 15) {
            answers.push(blankAnswer);
            this.setState({answers})
        }
    }

    deleteAnswer = (index) => {
        let { answers } = this.state;
        answers.splice(index, 1);

        this.setState({answers});
    }

    changeRightAnswer = (checkAnswer) => {
        this.setState({checkAnswer})
    }
    
    changeTitle = (event) => {
        let title = event.target.value;

        this.setState({
            title,
            slug: window.helperFunc.titleToSlug(title, 100),
        })
    }

    changeSlug = (event) => {
        let slug = event.target.value;

        this.setState({
            slug: window.helperFunc.titleToSlug(slug, 100),
        })
    }

    handleChangeEditor = (value, editor, flag) => {
        this.setState({ [flag]: value });
    }

    handleChangeAnswer = (value, editor, index) => {
        let { answers } = this.state;

        const newAnswers = answers.map((answer, i) => {
            if (index !== i) {
                return answer;
            } else {
                return {...answer, content: value};
            }
        });

        this.setState({answers: newAnswers});
    }

    handleSubmitQuestion = (event) => {
        event.preventDefault();

        let {content, reason, answers, isNewQuestion} = this.state;

        let msg = '';

        if (window.helperFunc.checkImageContent(content)) {
            msg += 'N???i dung c??u h???i ch???a link ???nh kh??ng h???p l???!' + "\r\n";
        }

        if (window.helperFunc.checkImageContent(reason)) {
            msg += 'N???i dung ph???n gi???i th??ch ch???a link ???nh kh??ng h???p l???!' + "\r\n";
        }

        answers.forEach((answer, index) => {
            if (window.helperFunc.checkImageContent(answer.content)) {
                msg += 'N???i dung ????p ??n ' + (index + 1) + ' ch???a link ???nh kh??ng h???p l???!' + "\r\n";
            }
        });

        if (msg.length > 0) {
            alert(msg + 'B???n ph???i upload b???ng editor, kh??ng ??c k??o th??? ho???c copy - paste!');

            return;
        }

        this.setState({isButtonLoading: true});

        if (isNewQuestion) {
            return this.addNewQuestion();
        } else {
            return this.editQuestion();
        }
    }

    addNewQuestion = () => {
        const _that = this;
        const { title, slug, content, reason, answers, checkAnswer } = _that.state;
        const { curriculum } = _that.props;
        const data = {
            title,
            slug,
            content,
            reason,
            curriculum_id: curriculum.id,
            answers,
            checkAnswer
        };

        axios.post('questions', data).then((response) => {
            if (response.status === 200) {
                _that.context.handleSubmitQuestion(response.data.question);
            }
        }).catch(function(error) {
            if (error.response && error.response.status === 422) {
                const { errors } = error.response.data;
                let msg = '';

                for (let [key, value] of Object.entries(errors)) {
                    msg += value[0] + "\r\n";
                }

                alert(msg.length > 0 ? msg : 'C?? l???i x???y ra! vui l??ng li??n h??? t??? IT.');
            } else if (error.response && error.response.data && error.response.data.message) {
                const msg = error.response.status === 419 ?
                    'Phi??n l??m vi???c tr??n form ???? h???t h???n. Vui l??ng t???i l???i trang!' :
                    error.response.data.message;

                alert(msg);
            } else {
                window.location.reload();
            }

            _that.setState({isButtonLoading: false});
        });
    }

    editQuestion = () => {
        const _that = this;
        const { title, slug, content, reason, answers, checkAnswer } = _that.state;
        const { curriculum, question } = _that.props;
        const data = {
            title,
            slug,
            content,
            reason,
            curriculum_id: curriculum.id,
            answers,
            checkAnswer
        };

        axios.post(`questions/${question.id}`, data).then((response) => {
            if (response.status === 200) {
                _that.context.handleSubmitQuestion(response.data.question);
            }
        }).catch(function(error) {
            if (error.response && error.response.status === 422) {
                const { errors } = error.response.data;
                let msg = '';

                for (let [key, value] of Object.entries(errors)) {
                    msg += value[0] + "\r\n";
                }

                alert(msg.length > 0 ? msg : 'C?? l???i x???y ra! vui l??ng li??n h??? t??? IT.');
            } else if (error.response && error.response.data && error.response.data.message) {
                const msg = error.response.status === 419 ?
                    'Phi??n l??m vi???c tr??n form ???? h???t h???n. Vui l??ng t???i l???i trang!' :
                    error.response.data.message;

                alert(msg);
            } else {
                window.location.reload();
            }

            _that.setState({isButtonLoading: false});
        });
    }

    render() {
        const {toggleQuestionForm} = this.props;
        let {title, slug, content, reason, answers, checkAnswer, isButtonLoading} = this.state;

        let answersElem = answers.map((answer, i) => {
            return (
                <div className="answer-content-wrapper" key={i}>
                    <div className="answer-check">
                        <label className="custom-control custom-radio">
                            <input
                                type="radio"
                                className="custom-control-input"
                                name="answer"
                                checked={checkAnswer === i}
                                value={i}
                                onChange={() => this.changeRightAnswer(i)}
                            />
                            <span className="custom-control-indicator"></span>
                        </label>
                    </div>
                    <TinymceEditor
                        index={i}
                        value={answer.content}
                        handleChangeEditor={(value, editor) => this.handleChangeAnswer(value, editor, i)}
                    />
                    <div className="answer-toolbar">
                        <button
                            onClick={() => this.deleteAnswer(i)}
                            type="button"
                        >
                            <i className="fa-trash-o fa"></i>
                        </button>
                    </div>
                </div>
            )
        })

        return (
            <div className="lecture-add-more">
                <div className="content-type-close">
                    Th??m c??u tr???c nghi???m
                    <button
                        onClick={() => toggleQuestionForm(false)}
                    ><i className="fa fa-times" aria-hidden="true"></i></button>
                </div>
                <div className="add-content-wrapper">
                    <form className="quiz-add-content" onSubmit={this.handleSubmitQuestion}>
                        <p>C??u h???i</p>
                        <TinymceEditor
                            value={content}
                            handleChangeEditor={(value, editor) => this.handleChangeEditor(value, editor, 'content')}
                        />
                        <br/>
                        <div className="form-group answers-form-group">
                            <p>C??u tr??? l???i</p>
                        </div>

                        {answersElem}

                        <button type="button" className="btn btn-info" onClick={this.addNewAnswer}>Th??m ????p ??n</button>
                        <span className="help-block">C?? th??? th??m l??n ?????n 15 ????p ??n.</span>
                        <div className="test-explain">
                            <label>Gi???i th??ch</label>
                            <TinymceEditor
                                value={reason}
                                handleChangeEditor={(value, editor) => this.handleChangeEditor(value, editor, 'reason')}
                            />
                        </div>
                        <br />
                        <div className="form-group answer-related-relatedLecture">
                            <p>Ti??u ????? SEO c??u h???i</p>
                            <input className="form-control bg-white" onChange={this.changeTitle} value={title} required />
                        </div>
                        <div className="form-group answer-related-relatedLecture">
                            <p>???????ng d???n slug c??u h???i (t???i ??a 100 k?? t???)</p>
                            <input className="form-control bg-white" onChange={this.changeSlug} value={slug} required />
                        </div>
                        <div className="text-right form-actions">
                            <ButtonSubmit
                                isLoading={isButtonLoading}
                            >
                                L??u l???i
                            </ButtonSubmit>
                        </div>
                    </form>
                </div>
            </div>
        )
    }
}

export default QuestionForm;
