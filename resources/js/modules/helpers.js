function contains(target, pattern){
    let value = 0;

    pattern.forEach(function(word){
        value = value + target.includes(word);
    });

    return (value === 1)
}

const helperFunc = {
    titleToSlug: function (str = '', limit = 70) { // convert str to slug
        str = str.replace(/^\s+|\s+$/g, ''); // trim
        str = str.toLowerCase();
        // remove accents, swap ñ for n, etc
        var from = "áàảạãăắằẳẵặâấầẩẫậäéèẻẽẹêếềểễệëíìỉĩịïóòỏõọôốồổỗộơớờởỡợöúùủũụưứừửữựüûýỳỷỹỵđñç·/_,:;";
        var to   = "aaaaaaaaaaaaaaaaaaeeeeeeeeeeeeiiiiiioooooooooooooooooouuuuuuuuuuuuuyyyyydnc------";

        for (var i=0, l=from.length ; i<l ; i++) {
            str = str.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
        }

        str = str.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
            .replace(/\s+/g, '-') // collapse whitespace and replace by -
            .replace(/-+/g, '-') // collapse dashes
            .replace(/^-/, '') // remove hyphens from first str
            .replace(/[^-]-$/, ''); // remove hyphens from last str

        return limit < 0 ? str : str.substring(0, limit);
    },
    isMobile: function() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    },
    getMobileOperatingSystem: function() {
        var userAgent = navigator.userAgent || navigator.vendor || window.opera;

        if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) {
            return 'iOS';
        }

        if (/android/i.test(userAgent)) {
            return 'Android';
        }

        return 'unknown';
    },
    checkImageContent: function(content = '') {
        let blackList = ['.googleusercontent.', ';base64,'];

        return contains(content, blackList);
    }
}

export default helperFunc;
