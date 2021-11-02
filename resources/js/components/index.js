import ReactDom from 'react-dom';
import Curriculum from './curriculums/Curriculum';

if (document.getElementById('curriculums')) {
    const element = document.getElementById('curriculums');
    const props = Object.assign({}, element.dataset);

    ReactDom.render(
        <Curriculum {...props}/>,
        element
    );
}
