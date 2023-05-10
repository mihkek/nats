$.ajax({
method: "get",
url: "/admin/messages/counter",
success: function (result) {
if (result.data !==undefined) {
let count = result.data;
$("#message-counter").text(count);
}
},
error: function (result) {
console.log('ошибка');
}
});
