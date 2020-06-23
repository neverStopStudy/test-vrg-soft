$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#addBtn").click(function() {
        $(".modal-title").html('Добавить автора');
        $("#changeBtn").css("display","none");
        $("#submitBtn").css("display","block");
    });

    let author_id;
    $(".edit-btn").click(function() {
        $("#submitBtn").css("display","none");
        $("#changeBtn").css("display","block");

        author_id = $(event.target).attr("author-id");
        let myurl = "/author/" + author_id;

        $.ajax({
            type: "GET",
            url: myurl,
            data: author_id,
            success: function (data) {
                $(".modal-title").html('Редактировать автора');
                $("#nameInput").val(data['name']);
                $("#surnameInput").val(data['surname']);
                $("#patronymicInput").val(data['patronymic']);
                console.log(data);
            }
        });
        $(".modal-title").html('Редактировать автора');
    });

    $("#changeBtn").click(function() {
        let formData = new FormData();
        formData.append('name', $("#nameInput").val());
        formData.append('surname', $("#surnameInput").val());
        formData.append('patronymic', $("#patronymicInput").val());

        console.log(formData);
        let countRows = $('table>tbody>tr>th[scope=row]').length+1;

        let urlUpdate = "/author/" + author_id + "/update";
        $.ajax({
            type: "POST",
            url: urlUpdate,
            contentType: false,
            processData: false,
            data: formData,
            beforeSend: function() {
                $('#addForm').find('input button').prop("disabled",true);
            },
            success: function (data) {
                console.log("successffffffffffuul");
                console.log(data);
            },
            complete: function() {
                $('#addForm').find('input button').prop("disabled",false);
            },
            statusCode: {
                422: function (data) {
                    const errors = JSON.parse(data.responseText).errors;
                    alert(Object.values(errors).shift());
                }
            }
        });
    });
    let countRows = $('table>tbody>tr>th[scope=row]').length+1;
    $("#submitBtn").click(function() {

        let formData = new FormData();
        formData.append('name', $("#nameInput").val());
        formData.append('surname', $("#surnameInput").val());
        formData.append('patronymic', $("#patronymicInput").val());

        console.log(formData);
        $.ajax({
            type: "POST",
            url: "/author/store",
            contentType: false,
            processData: false,
            data: formData,
            beforeSend: function() {
                $('#addForm').find('input').prop("disabled",true);
            },
            done: function (data) {
                console.log(data);
            },
            success: function (data) {
                console.log("successffffffffffuul");
                console.log(data);
                countRows++;
                $("table").append(
                    '<tr>' +
                    '<th scope="row">'+ countRows +'</th>' +
                    '<th>' + data['name'] + '</th>' +
                    '<th>' + data['surname'] + '</th>' +
                    '<th>' +
                    '<div class="btn-group">' +
                    '<div class="btn-group__control">' +
                    '<a href=' + "author/" + data['id']  + "/" + '>' +
                    '<button type="button" class="btn btn-success">Просмотреть</button>'+
                    '</a>'+
                    '</div>' +
                    '<div class="btn-group__control">'+
                    '<button type="button" class="btn btn-warning edit-btn" data-toggle="modal" data-target="#modal" author-id=' + data['id'] + '>'
                    + 'Изменить'+
                    '</button>' +
                    '</div>' +
                    '<div class="btn-group__control">' +
                    '<form action=' + "author/" + data['id'] + "/destroy" +  'method="get">' +
                    '@csrf'+
                    '@method("DELETE")'+
                    '<button type="submit" class="btn btn-danger admin-delete-btn" >Удалить</button>'+
                    '</form>' +
                    '</div>' +
                    '</div>' +
                    '</th>' +
                    '</tr>')
            },
            complete: function() {
                $('#addForm').find('input').prop("disabled",false);
            },
            statusCode: {
                422: function (data) {
                    const errors = JSON.parse(data.responseText).errors;
                    alert(Object.values(errors).shift());
                }
            }
        });
    });
});