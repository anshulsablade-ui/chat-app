$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function ajaxCall(url, method, data, successCallback, errorCallback) {
    $.ajax({
        url: url,
        type: method,
        data: data,
        processData: false,
        contentType: false,
        // global: false,
        success: successCallback,
        error: errorCallback
    });
}

$('body').on('click', '.chatUser', function (e) {
    e.preventDefault();
    let url = $(this).attr('href');
    ajaxCall(url, 'post', null, function (response) {
        $('.main').html(response);
    }, function (response) {
        alert('Error:' + response);
        // console.log(response);
    });
});

// $("#messageSendForm").submit(function (e) { 
//     e.preventDefault();
//     let formData = new FormData(this);
//     let url = $(this).attr('action');
//     ajaxCall(url, 'post', formData, function (response) {
//         $('.main').html(response);
//     }, function (response) {
//         alert('Error:' + response);
//         // console.log(response);
//     });
// });

// Echo.join('online')
//     .here((users) => {
//         users.forEach(user => setOnline(user.id));
//     })
//     .joining((user) => {
//         setOnline(user.id);
//     })
//     .leaving((user) => {
//         setOffline(user.id);
//     });


// function setOnline(userId) {
//     $(`#user-${userId} .status`).removeClass('avatar-offline');
//     $(`#user-${userId} .status`).addClass('avatar-online');
// }

// function setOffline(userId) {
//     $(`#user-${userId} .status`).removeClass('avatar-online');
//     $(`#user-${userId} .status`).addClass('avatar-offline');
// }


// Echo.join(`chat.${roomId}`)
//     .here(/* ... */)
//     .joining(/* ... */)
//     .leaving(/* ... */)
//     .listen('NewMessage', (e) => {
//         // ...
//     });