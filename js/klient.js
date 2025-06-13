$(document).ready(function(){
    $('#ugyfelid').on('input', function() {
        var query = $(this).val();
        if (query.length > 0) {
            $.ajax({
                url: 'src/app/view/task/get_clients.php',
                method: 'GET',
                data: { query: query },
                success: function(data) {
                    $('#clientList').empty();
                    try {
                        var clients = JSON.parse(data);
                        clients.forEach(function(client) {
                            $('#clientList').append(
                                '<li class="list-group-item client-item" data-id="' + client.id + '">' +
                                client.firstname + ' ' + client.lastname + ' - ' +
                                client.street + ', ' + client.zip + ' ' + client.country +
                                '</li>'
                            );
                        });

                        $('.client-item').on('click', function() {
                            $('#ugyfelid').val($(this).text());
                            $('#clientList').empty();
                        });
                    } catch (e) {
                        console.error('JSON hiba: ', e);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX hiba: ', textStatus, errorThrown);
                }
            });
        } else {
            $('#clientList').empty();
        }
    });
});
