var urlRegexPattern = '(?!mailto:)(?:(?:http|https|ftp)://)(?:\\S+(?::\\S*)?@)?(?:(?:(?:[1-9]\\d?|1\\d\\d|2[01]\\d|22[0-3])(?:\\.(?:1?\\d{1,2}|2[0-4]\\d|25[0-5])){2}(?:\\.(?:[0-9]\\d?|1\\d\\d|2[0-4]\\d|25[0-4]))|(?:(?:[a-z\\u00a1-\\uffff0-9]+-?)*[a-z\\u00a1-\\uffff0-9]+)(?:\\.(?:[a-z\\u00a1-\\uffff0-9]+-?)*[a-z\\u00a1-\\uffff0-9]+)*(?:\\.(?:[a-z\\u00a1-\\uffff]{2,})))|localhost)(?::\\d{2,5})?(?:(/|\\?|#)[^\\s]*)?';
var urlRegex = new RegExp(urlRegexPattern, 'ugi');

function showLinksInText(text) {
    return text.replace(urlRegex, '<a href="$&">$&</a>');
}

function formatTimestamp(timestamp) {
    var date = new Date(timestamp * 1000);
    day = date.getDate();
    month = date.toLocaleString('en', {month: "short"});
    hour = (date.getHours() < 10 ? '0' : '') + date.getHours();
    minute = (date.getMinutes() < 10 ? '0' : '') + date.getMinutes();

    formatted_date = day + ' ' + month + ' ' + hour + ':' + minute;
    return formatted_date;
}

function sortMessagesByDateTime(message1, message2) {
    return message1.dateTime - message2.dateTime;
}
