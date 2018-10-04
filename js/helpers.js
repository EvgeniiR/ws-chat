function formatTimestamp(timestamp)
{
    var date = new Date(timestamp * 1000);
    day = date.getDate();
    month = date.toLocaleString('ru', { month: "short" });
    hour = date.getHours();
    minute = date.getMinutes();

    formatted_date = day + ' ' + month + ' ' + hour + ':' + minute;
    return formatted_date;
}