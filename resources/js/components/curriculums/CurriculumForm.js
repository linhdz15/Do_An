import React, {Component} from 'react';
import PropTypes from 'prop-types';
import TinymceEditor from './TinymceEditor';

class CurriculumForm extends Component {
    constructor(props) {
        super(props);

        this.state = {
            title: '',
            slug: '',
            description: '',
            time: 0,
            score: 0,
            isNewCurriculum: true,
        }
    }

    static getDerivedStateFromProps(nextProps, prevState) {
        if(!nextProps.isNewCurriculum && prevState.isNewCurriculum !== nextProps.isNewCurriculum) {
            const curriculum = nextProps.curriculum;

            return {
                title: curriculum.title,
                slug: curriculum.slug,
                description: curriculum.description,
                time: curriculum.time,
                score: curriculum.score,
                isNewCurriculum: nextProps.isNewCurriculum,
            };
        }

        return null;
    }

    static contextTypes = {
        handleSubmitCurriculum: PropTypes.func.isRequired,
    };

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

    changeTime = (event) => {
        this.setState({ time: event.target.value });
    }

    changeScore = (event) => {
        this.setState({ score:event.target.value });
    }

    handleChangeEditor = (value, editor, flag) => {
        this.setState({ [flag]: value });
    }

    handleSubmitCurriculum = (event) => {
        event.preventDefault();

        let {isNewCurriculum} = this.state;

        if (isNewCurriculum) {
            return this.addNewCurriculum();
        } else {
            return this.editCurriculum();
        }
    }

    addNewCurriculum = () => {
        const _that = this;
        const {title, slug, description, time, score} = _that.state;
        const { isCurriculumParent } = _that.props;
        const data = {title, slug, description, time, score, isCurriculumParent};

        axios.post('curriculums', data).then((response) => {
            if (response.status === 200) {
                _that.context.handleSubmitCurriculum(response.data.curriculum);
            }
        }).catch(function(error) {
            if (error.response && error.response.status === 422) {
                const { errors } = error.response.data;
                let msg = '';

                for (let [key, value] of Object.entries(errors)) {
                    msg += value[0] + "\r\n";
                }

                alert(msg.length > 0 ? msg : 'Có lỗi xảy ra! vui lòng liên hệ tổ IT.');
            } else if (error.response && error.response.data && error.response.data.message) {
                const msg = error.response.status === 419 ?
                    'Phiên làm việc trên form đã hết hạn. Vui lòng tải lại trang!' :
                    error.response.data.message;

                alert(msg);
            } else {
                window.location.reload();
            }
        })
    }

    editCurriculum = () => {
        const _that = this;
        const {title, slug, description, time, score} = _that.state;
        const data = {title, slug, description, time, score};

        axios.post(`curriculums/${_that.props.curriculum.id}`, data).then((response) => {
            if (response.status === 200) {
                _that.context.handleSubmitCurriculum(response.data.curriculum);
            }
        }).catch(function(error) {
            if (error.response && error.response.status === 422) {
                const { errors } = error.response.data;
                let msg = '';

                for (let [key, value] of Object.entries(errors)) {
                    msg += value[0] + "\r\n";
                }

                alert(msg.length > 0 ? msg : 'Có lỗi xảy ra! vui lòng liên hệ tổ IT.');
            } else if (error.response && error.response.data && error.response.data.message) {
                const msg = error.response.status === 419 ?
                    'Phiên làm việc trên form đã hết hạn. Vui lòng tải lại trang!' :
                    error.response.data.message;

                alert(msg);
            } else {
                window.location.reload();
            }
        })
    }

    render() {
        const {toggleCurriculumForm, isCurriculumParent, isNewCurriculum} = this.props;
        let {title, slug, description, time, score} = this.state;

        return (
            <div className="form-wrapper">
                <form className="form-section" onSubmit={this.handleSubmitCurriculum}>
                    <div>
                        <div className="form-title text-center">
                            { isCurriculumParent ? 'Phần' : 'Đề thi' }
                        </div>
                        <div className="form-content">
                            <div className="form-group form-group-sm">
                                <label className="control-label">Tiêu đề</label>
                                <input
                                    placeholder="Nhập tiêu đề"
                                    className="form-control bg-white"
                                    type="text"
                                    value={title}
                                    onChange={this.changeTitle}
                                    required
                                />
                            </div>
                            <div className="form-group form-group-sm">
                                <label className="control-label">Slug (tối đa 100 ký tự)</label>
                                <input
                                    placeholder="Slug"
                                    className="form-control bg-white"
                                    type="text"
                                    value={slug}
                                    onChange={this.changeSlug}
                                    required
                                />
                            </div>
                            <div className="form-group form-group-sm">
                                <label className="control-label">Miêu tả</label>
                                <TinymceEditor
                                    value={description}
                                    handleChangeEditor={(value, editor) => this.handleChangeEditor(value, editor, 'description')}
                                    simple={true}
                                />
                            </div>
                            { !isCurriculumParent && (
                                <>
                                    <div className="form-group form-group-sm">
                                        <label className="control-label">Thời lượng (phút)</label>
                                        <input
                                            className="form-control bg-white"
                                            type="text"
                                            value={time}
                                            onChange={this.changeTime}
                                            required
                                        />
                                    </div>
                                    <div className="form-group form-group-sm">
                                        <label className="control-label">Điểm tối đa cần đạt</label>
                                        <input
                                            className="form-control bg-white"
                                            type="text"
                                            value={score}
                                            onChange={this.changeScore}
                                            required
                                        />
                                    </div>
                                </>
                            ) }
                        </div>
                    </div>
                    <div className="text-right form-actions">
                        <button
                            className="btn btn-link"
                            type="button"
                            onClick={() => toggleCurriculumForm(false)}
                        > Đóng</button>
                        <button className="btn btn-primary" type="submit">{ isNewCurriculum ? 'Thêm mới' : 'Cập nhật' }</button>
                    </div>
                </form>
            </div>
        )
    }
}

export default CurriculumForm;
