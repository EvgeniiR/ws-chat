function formatTimestamp(timestamp) {
    var date = new Date(timestamp * 1000);
    day = date.getDate();
    month = date.toLocaleString('ru', {month: "short"});
    hour = (date.getHours() < 10 ? '0' : '') + date.getHours();
    minute = (date.getMinutes() < 10 ? '0' : '') + date.getMinutes();

    formatted_date = day + ' ' + month + ' ' + hour + ':' + minute;
    return formatted_date;
}