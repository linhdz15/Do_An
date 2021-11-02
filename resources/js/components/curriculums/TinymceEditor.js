import React, {Component} from 'react';
import { Editor } from '@tinymce/tinymce-react';
import { TINY_MCE_WIRIS, URL_IMAGE_UPLOAD } from '../const';

class TinymceEditor extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        let {handleChangeEditor, value, simple} = this.props;

        return simple ? (
            <Editor
                value={value}
                onEditorChange={handleChangeEditor}
                init={{
                    menubar: false,
                    toolbar: 'bold italic',
                    content_style: 'body { font-family:"Times New Roman", Times, serif; font-size:18px }',
                    paste_data_images: false,
                    remove_script_host : true,
                    language: 'vi',
                }}
            />
        ) : (
            <Editor
                value={value}
                onEditorChange={handleChangeEditor}
                init={{
                    menubar: false,
                    plugins: [
                        'advlist autolink lists link image charmap print preview anchor',
                        'searchreplace visualblocks code fullscreen',
                        'insertdatetime media table paste code help wordcount'
                    ],
                    toolbar: 'tiny_mce_wiris_formulaEditor tiny_mce_wiris_formulaEditorChemistry | undo redo | fontsizeselect fontselect formatselect | ' +
                        'bold italic backcolor | alignleft aligncenter ' +
                        'alignright alignjustify | image | bullist numlist outdent indent | ' +
                        'removeformat | fullscreen | wordcount',
                    content_style: 'body { font-family:"Times New Roman", Times, serif; font-size:18px }',
                    font_formats: 'Times New Roman="Times New Roman", Times, serif;',
                    fontsize_formats: '8px 9px 10px 11px 12px 14px 16px 18px 24px 30px 36px 48px 60px 72px 96px',
                    paste_data_images: false,
                    relative_urls : false,
                    remove_script_host : true,
                    external_plugins: {
                        'tiny_mce_wiris': TINY_MCE_WIRIS
                    },
                    language: 'vi',
                    file_picker_callback: function (callback, value, meta) {
                        let input = document.createElement('input');
                        input.setAttribute('type', 'file');
                        input.setAttribute('accept', 'image/*');
                        input.click();

                        input.onchange = function () {
                            let file = this.files[0];
                            let formData = new FormData();
                            formData.append('image', file);

                            axios.post(URL_IMAGE_UPLOAD, formData)
                                .then(res => {
                                    const { data } = res;

                                    if (data.uploaded) {
                                        callback(data.url, { alt: 'VietJack' });
                                    } else {
                                        alert(data.error.message);
                                    }
                                })
                                .catch(err => {
                                    console.log(err.message);
                                })
                        };
                    },
                }}
            />
        );
    }
}

export default TinymceEditor;
