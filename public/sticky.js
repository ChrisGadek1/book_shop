let orderPages = 1;

window.onload = function () {
    var navbar = $("#main_menu_container")[0];
    // Get the offset position of the navbar
    var sticky = navbar.offsetTop;
    let number = 1;
    function myFunction() {
        if (window.pageYOffset >= sticky) {
            navbar.classList.add("sticky");
        } else {
            navbar.classList.remove("sticky");
        }
    }

    window.onscroll = function () {
        myFunction()
    };
    $("#log_in_or_out").on("click", function () {
        if ($.trim($("#log_in_or_out").html()) == "Zaloguj") {
            window.location.href = "/login";
        } else {
            window.location.href = "/logout";
        }
    });
    $("#user_login").on("input", function () {
        $("#post_login_error").html("");
        $("#login_test").html("Sprawdzanie loginu...");
        $("#login_test").css("color", "black");
        if ($("#user_login").val() == "") {
            $("#login_test").html("");
        } else if (!$("#user_login").val().match("^[a-zA-Z0-9]+$")) {
            $("#login_test").html("Tylko litery i cyfry");
            $("#login_test").css("color", "red");
        } else {
            let xhtml = new XMLHttpRequest();
            xhtml.onreadystatechange = function () {
                if (this.responseText == "T") {
                    $("#login_test").html("Taki login już istnieje");
                    $("#login_test").css("color", "red");
                } else if (this.responseText == "F") {
                    $("#login_test").html("Login poprawny");
                    $("#login_test").css("color", "green");
                }
            }
            xhtml.open("GET", "/registerLogin?q=" + $("#user_login").val(), true);
            xhtml.send();
        }
    });
    $("#email_field").on("input", function () {
        $("#post_email_error").html("");
        if ($("#email_field").val() == "") {
            $("#email_test").html("");
        } else if (!$("#email_field").val().match("^[a-z0-9]+@[a-z0-9]+\\.[a-z]+$")) {
            $("#email_test").html("Wprowadź poprawny e-mail");
            $("#email_test").css("color", "red");
        } else {
            $("#email_test").html("E-mail poprawny");
            $("#email_test").css("color", "green");
        }
    });
    $("#password_1_id").on("input", function () {
        $("#post_password_1_error").html("");
        let pass = $("#password_1_id").val();
        if (($("#password_1_id").val().length > 0 && $("#password_1_id").val().length < 8) || $("#password_1_id").val().length > 30) {
            $("#password_test_1").html("Hasło powinno mieć od 8 do 30 znaków");
            $("#password_test_1").css("color", "red");
        } else if (!(pass.match(".*[a-z].*") && pass.match(".*[A-Z].*") && pass.match(".*[0-9].*")) && pass.length > 0) {
            $("#password_test_1").html("Wymagane duże i małe litery oraz cyfry");
            $("#password_test_1").css("color", "red");
        } else {
            $("#password_test_1").html("");
        }

    });
    $("#password_2_id").on("change", function () {
        $("#post_pasword_2_error").html("");
        if ($("#password_2_id").val() != $("#password_1_id").val()) {
            $("#password_test_2").html("Hasła nie są takie same");
            $("#password_test_2").css("color", "red");
        } else {
            $("#password_test_2").html("");
        }
    });
    $("#button-1").on("click", function (event) {
        $(".product_button").addClass("pressed");
        $("#button-1").removeClass("pressed");
        $("#main_product").empty();
        $("#main_product").append("" +
            "<div id='desc_container'>" +
                "<div>Tytuł: "+title+"</div>\n" +
                "<img src="+pathToPhoto+">\n" +
                "<div>Autor: "+author+"</div>\n" +
                "<div>Cena: "+price+"zł</div>\n"+
            "</div>"
        );
        if(logged){
            $("#desc_container").append(
                "<div id='buy_button'>Kup Teraz!</div>"
            );
            $("#buy_button").on("click", function (){
                if(confirm("Czy na pewno Chcesz zakupić ten produkt?")){
                    let xhtml = new XMLHttpRequest();
                    xhtml.onreadystatechange = function (){
                        if(this.readyState == 4 && this.status == 200){
                            console.log(this.responseText);
                            $("#buy_button").remove();
                            $("#desc_container").append(
                                "<div>Dziękujemy za zakupy w naszym sklepie!</div>"
                            );
                        }
                    }
                    xhtml.open("GET","/buy?id="+id+"&login="+login, true);
                    xhtml.send();
                }
            });
        }
        else{
            $("#desc_container").append(
                "<div id='cannot_buy'>Aby kupić książkę, zaloguj się</div>"
            );
        }
    });
    $("#button-2").on("click", function (event) {
        $(".product_button").addClass("pressed");
        $("#button-2").removeClass("pressed");
        $("#main_product").empty();
        $("#main_product").append("" +
            "<div>Trwa ładowanie opinii...</div>"
        );
        let xhtml = new XMLHttpRequest();
        xhtml.onreadystatechange = getComments(number);
        xhtml.open("GET", "/getComments?q=" + id+"&part="+number, true);
        xhtml.send();
    });
    $("#user_button_1").on("click", function(){
        $("#user_data").empty();
       $(".product_button_3").addClass("pressed");
       $("#user_button_1").removeClass("pressed");
       $("#user_data").append(
           "<div id='login_container' class='user_container'>" +
                "<div>Login:   </div>"+
                "<div class='data user_inner'>"+login+"</div>"+
                "<div class='edit_button user_inner' id='login_button'>Edytuj</div>"+
                "<div style='clear: both;' class='clear_both'></div>"+
           "</div>"+
           "<div id='email_container' class='user_container'>" +
                "<div>Email:    </div>"+
                "<div class='data user_inner'>"+email+"</div>"+
                "<div class='edit_button user_inner' id='email_button'>Edytuj</div>"+
                "<div style='clear: both;' class='clear_both'></div>"+
           "</div>"+
           "<div id='address_container' class='user_container'>" +
                "<div>Adres:    </div>"+
                "<div class='data user_inner'>"+address+"</div>"+
                "<div class='edit_button user_inner' id='address_button'>Edytuj</div>"+
                "<div style='clear: both;' class='clear_both'></div>"+
           "</div>"
       );
       $(".edit_button").on("click", change);
    });
    $("#user_button_2").on("click", loadOrders(1));
    $(".edit_button").on("click", change);
    $("#main_tile").on("click", function (){
        window.location.href = "/";
    });
    $("#buy_button").on("click", function (){
        if(confirm("Czy na pewno Chcesz zakupić ten produkt?")){
            let xhtml = new XMLHttpRequest();
            xhtml.onreadystatechange = function (){
                console.log(login);
                console.log(id);
                if(this.readyState == 4 && this.status == 200){
                    console.log(this.responseText);
                    $("#buy_button").remove();
                    $("#desc_container").append(
                        "<div>Dziękujemy za zakupy w naszym sklepie!</div>"
                    );
                }
            }
            xhtml.open("GET","/buy?id="+id+"&login="+login, true);
            xhtml.send();
        }
    });
}

function redirect(what, subcat){
    window.location.href = '/find/'+what+'/'+subcat+'/1';
}

function getComments(number){
    return function (){
        let response;
        if (this.readyState == 4 && this.status == 200) {
            response = JSON.parse(this.responseText);
            response = JSON.parse(response);
            $("#main_product").empty();
            if(!logged){
                $("#main_product").append(
                    "<div>Aby dodać komentarz, zaloguj się.</div>"
                );
            }
            else{
                $("#main_product").append(
                    "<div id='enter_comment_container'>" +
                    "<div class='upper_comment'>" +
                    "<div style='padding: 2px 0px 2px 0px;'>Dodaj własną opinię</div>"+
                    "<select id='mark_choose' name='mark_choose'>"+
                    "<option value='1'>1</option>"+
                    "<option value='2'>2</option>"+
                    "<option value='3'>3</option>"+
                    "<option value='4'>4</option>"+
                    "<option value='5'>5</option>"+
                    "<option value='6'>6</option>"+
                    "<option value='7'>7</option>"+
                    "<option value='8'>8</option>"+
                    "<option value='9'>9</option>"+
                    "<option value='10'>10</option>"+
                    "</select>"+
                    "<label for='mark_choose' id='label_choose'>ocena: </label>"+
                    "</div>"+
                    "<textarea name='comment' id='comment_area'></textarea>"+
                    "<button type='button' id='add_button'>Dodaj</button>"+
                    "</div>"
                );
            }
            let i = 0
            for(; i < response.length - 2 && i < 10; i++){
                $("#main_product").append(
                    "<div id='comment_container'>" +
                        "<div class='upper_comment'>" +
                            "<div class='user_comment'>"+response[i].user+"</div>"+
                            "<div class ='user_comment'>"+response[i].date+"</div>"+
                            "<div style='clear: both;'></div>"+
                            "<div id='mark'>Ocena: "+response[i].ocena+"/10</div>"+
                        "</div>"+
                        "<div id='main_opinion'>"+response[i].opinia+"</div>"+
                    "</div>"
                );
            }
            if(response[response.length - 2].more){
                $("#main_product").append(
                    "<div id='choose_comment_container'></div>"
                );
                if(!(number == 1)){
                    $("#choose_comment_container").append(
                        "<div class='next_com' id='prev_comment'>poprzednia" +
                        "</div>"
                    );
                }
                if(!(response[response.length - 1].last)){
                    $("#choose_comment_container").append(
                        "<div class='next_com' id='next_comment'>następna</div>"
                    );
                }
                $("#choose_comment_container").append(
                    "<div style='clear: both;'></div>"+
                    "</div>"
                );
            }
            $("#prev_comment").on("click", function (){
                $("#main_product").empty();
                $("#main_product").append("" +
                    "<div>Trwa ładowanie opinii...</div>"
                );
                let xhtml = new XMLHttpRequest();
                number -= 1;
                xhtml.onreadystatechange = getComments(number);
                xhtml.open("GET", "/getComments?q=" + id+"&part="+number, true);
                xhtml.send();
            });

            $("#next_comment").on("click", function (){
                $("#main_product").empty();
                $("#main_product").append("" +
                    "<div>Trwa ładowanie opinii...</div>"
                );
                let xhtml = new XMLHttpRequest();
                number += 1;
                xhtml.onreadystatechange = getComments(number);
                xhtml.open("GET", "/getComments?q=" + id+"&part="+number, true);
                xhtml.send();
            });
            $("#comment_area").on("input", function(){

            });
            $("#add_button").on("click",function (){
                let xhtml = new XMLHttpRequest();
                xhtml.onreadystatechange = function (){
                    let xhtml_1 = new XMLHttpRequest();
                    xhtml_1.onreadystatechange = getComments(1);
                    $("#enter_command_container").empty();
                    $("#enter_command_container").append(
                        "<div>Dodano komentarz</div>"
                    );
                    xhtml_1.open("GET", "/getComments?q=" + id+"&part="+number, true);
                    xhtml_1.send();
                }
                let comment = $("#comment_area").val();
                let processedComment = "";
                for(let i = 0; i < comment.length; i++){
                    if(comment[i] != ' '){
                        processedComment += comment[i];
                    }
                    else{
                        processedComment += "%20";
                    }
                }
                xhtml.open("GET","/addComment?"+"comment="+processedComment+"&login="+login+"&id="+id+"&ocena="+$("#mark_choose").val(),true);
                xhtml.send();
            });
        }
    }

}
change = function (){
    let what = "";
    if($(this).parent().attr('id') == "login_container"){
        what = "login";
    }
    else if($(this).parent().attr('id') == "email_container"){
        what = "email";
    }
    else{
        what = "address";
    }
    $(this).parent().find(".clear_both").remove();
    $(this).parent().append(
        "<div id='data_input'>" +
            "<label class='data' for='"+what+"_input'>Wprowadź nowe dane:</label>"+
            "<input type='text' class='data' name='"+what+"_input' id='"+what+"_input'>"+
            "<div id='"+$(this).parent().attr('id')+"_accept' class='edit_button_1'>Zatwierdź</div>"+
            "<div style='clear: both;' class='clear_both'></div>"+
        "</div>"+
        "<div style='clear: both;' class='clear_both'></div>"
    );
    $(this).off();
    let parent = $(this).parent();
    $(".edit_button_1").on("click", function (){
        let newData = $("#"+what+"_input").val();
        let xhtml = new XMLHttpRequest();
        xhtml.onreadystatechange = function(){
            if(this.readyState == 4 && this.status == 200){
                $("#data_input").remove();
                parent.find(".data").html(newData);
                if(what == "login"){
                    login = newData;
                    $("#login_info").html("Zalogowano: "+login);
                }
                if(what == "email"){
                    email = newData;
                }
                if(what == "address"){
                    address = newData;
                }
            }
        };
        xhtml.open("GET","/changeData?"+"what="+what+"&newdata="+newData+"&login="+login,true);
        xhtml.send();
    });
}

function getOrders(){
    return function (){
        if(this.readyState == 4 && this.status == 200){
            let response = JSON.parse(this.responseText);
            response = JSON.parse(response);
            $("#user_data").empty();
            $("#user_data").append(
                "<div id='orders_container'>" +
                    "<div style='font-size:32px; text-align: center; margin-bottom: 20px;'>Historia wszystkich zamówień</div>"+
                    "<div style='text-align: right;'>Łączna cena wszystkich zamówień: "+response[response.length - 3].price+"zł</div>"+
                    "<div id='orders_main'>" +
                        "<div id='order_0' class='orders'>" +
                            "<div class='inner_order'>okładka/zdjęcie</div>"+
                            "<div class='inner_order'>tytuł/nazwa</div>"+
                            "<div class='inner_order'>autor</div>"+
                            "<div class='inner_order'>cena</div>"+
                            "<div style='clear: both;'></div>"+
                        "</div>"+
                    "</div>"+
                "</div>"
            );
            let i = 0;
            for(; i < response.length - 3 && i < 7; i++){
                $("#orders_main").append(
                    "<div class='orders' id='order_"+i+1+"'>" +
                        "<div class='inner_order'><img src='/images/test_image.jpg'></div>"+
                        "<div class='inner_order desc_order'>"+response[i].title+"</div>"+
                        "<div class='inner_order desc_order'>"+response[i].author+"</div>"+
                        "<div class='inner_order desc_order'>"+response[i].price+" zł</div>"+
                        "<div style='clear: both;'></div>"+
                    "</div>"
                );
            }
            if(response[response.length - 2].more == true){
                $("#orders_container").append(
                    "<div id='nav_orders_container'>" +
                        "<div id='nav_orders_main'></div>"+
                    "</div>"
                );
                if(orderPages != 1){
                    $("#nav_orders_main").append(
                        "<div id='prev_orders' class='nav_orders'>poprzednia</div>"
                    );
                    $("#prev_orders").on("click", function(){
                        orderPages -= 1;
                        loadOrders1();
                    });
                }
                if(response[response.length - 1].last != true){
                    $("#nav_orders_main").append(
                        "<div id='next_orders' class='nav_orders'>następna</div>"
                    );
                    $("#next_orders").on("click", function(){
                        orderPages += 1;
                        loadOrders1();
                    });
                }
                $("#nav_orders_main").append(
                    "<div style='clear: both'></div>"
                );
            }
        }
    }
}

function loadOrders1(){
    console.log("wywołano");
    $("#user_data").empty();
    $(".product_button_3").addClass("pressed");
    $("#user_button_2").removeClass("pressed");
    $("#user_data").append(
        "<div style='text-align: center;host'>Trwa wczytywanie zamówień</div>"
    );
    let xhtml = new XMLHttpRequest();
    xhtml.onreadystatechange = getOrders();
    xhtml.open("GET","/readOrders?login="+login+"&page="+orderPages,true);
    xhtml.send();
}

let loadOrders = function(){
    return function (){
        loadOrders1();
    }
}