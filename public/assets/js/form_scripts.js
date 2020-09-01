function submitRequest(e, path){
    console.log('test');
    e.preventDefault();

    var msg_list = document.querySelector('#msg_list');

    if (msg_list !== null) {
        msg_list.parentNode.removeChild(msg_list);
    }

    $.ajax({
        url: path,
        type: 'post',
        data:$('#siteForm').serialize(),
        success:function(result){
            document.querySelector('#messages').insertAdjacentHTML('beforeend', result);
        },
        error: function(result){
            console.log(result);
        }
    });
}