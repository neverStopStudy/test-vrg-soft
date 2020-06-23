$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#addBtn").click(function() {
        $(".modal-title").html('Добавить книгу');
        $("#changeBtn").css("display","none");
        $("#submitBtn").css("display","block");
    });

    let book_id;
    $(".edit-btn").click(function() {

        $("#submitBtn").css("display","none");
        $("#changeBtn").css("display","block");

        book_id = $(event.target).attr("book-id");
        let myurl = "/book/" + book_id;

        $.ajax({
            type: "GET",
            url: myurl,
            data: book_id,
            success: function (data) {
                $(".modal-title").html('Редактировать книгу');
                $("#nameInput").val(data['name']);
                $("#titleInput").val(data['title']);
                $("#dateInput").val(data['pub_date']);
            }
        });

        $(".modal-title").html('Редактировать книгу');
        $("#nameInput").html()

    });

    $("#changeBtn").click(function() {
        let formData = new FormData();
        let authors = [];
        formData.append('name', $("#nameInput").val());
        formData.append('title', $("#titleInput").val());
        for (let i=0; i < $('#authorInput option').length; i++)
        {
            if ($('#authorInput option')[i].selected == true){
                authors.push($('#authorInput option')[i].value);
            }
        }
        formData.append('authors', authors);
        formData.append('pub_date', $("#dateInput").val());
        formData.append('img', $('#imgInput')[0].files[0]);

        let countRows = $('table>tbody>tr>th[scope=row]').length+1;
        let urlUpdate = "/book/" + book_id + "/update";
        $.ajax({
            type: "POST",
            url: urlUpdate,
            contentType: false,
            processData: false,
            data: formData,
            beforeSend: function() {
                $('#addForm').find('input, select, textarea').prop("disabled",true);
            },
            complete: function() {
                $('#addForm').find('input, select, textarea').prop("disabled",false);
            },
            statusCode: {
                422: function (data) {
                    const errors = JSON.parse(data.responseText).errors;
                    alert(Object.values(errors).shift());
                }
            }
        });
    });

    $("#submitBtn").click(function() {

        let formData = new FormData();
        let authors = [];
        formData.append('name', $("#nameInput").val());
        formData.append('title', $("#titleInput").val());
        for (let i=0; i < $('#authorInput option').length; i++)
        {
            if ($('#authorInput option')[i].selected == true){
                authors.push($('#authorInput option')[i].value);
            }
        }
        formData.append('authors', authors);
        formData.append('pub_date', $("#dateInput").val());
        formData.append('img', $('#imgInput')[0].files[0]);

        let countRows = $('table>tbody>tr>th[scope=row]').length+1;

        $.ajax({
            type: "POST",
            url: "/book/store",
            contentType: false,
            processData: false,
            data: formData,
            beforeSend: function() {
                $('#addForm').find('input, select, textarea').prop("disabled",true);
            },
            success: function (data) {
                let authors;
                data['authors'].forEach(function (element) {
                    authors += element.name + element.surname
                });
                $("table")
                    .append(
                        '<tr>' +
                        '<th scope="row">'+ countRows +'</th>' +
                        '<th>' + data['name'] + '</th>' +
                        '<th>'+ authors + '</th>' +
                        '<th>' +
                        '<div class="btn-group">' +
                        '<div class="btn-group__control">' +
                        '<a href=' + "book/" + data['id']  + "/" + '>' +
                        '<button type="button" class="btn btn-success">Просмотреть</button>'+
                        '</a>'+
                        '</div>' +
                        '<div class="btn-group__control">'+
                        '<button type="button" class="btn btn-warning edit-btn" data-toggle="modal" ' +
                        'data-target="#modal" book-id=' + data['id'] + '>'
                        + 'Изменить </button>' +
                        '</div>' +
                        '<div class="btn-group__control">' +
                        '<form action=' + "book/" + data['id'] + "/destroy" +  'method="get">' +
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
                $('#addForm').find('input, select, textarea').prop("disabled",false);
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


