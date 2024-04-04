var topNavbar = document.getElementById("home");
var tableName = "";
var reFullName = /^([A-ZŠČĆĐŽ][a-zščćđž]{2,14}){1,3}$/;
var reEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+(\\.[a-zA-Z0-9.-]+)*$/;
var rePassword = /^[A-Za-z\d]{8,20}$/;
var errors = [];

$(document).ready(function (){
    //REGISTER
    $("#mb-form-register").on("submit", function (e){
        e.preventDefault();

        let messageBoxRegister = document.getElementById("mb-register-message");

        let firstName = document.getElementById("first-name").value;
        let lastName = document.getElementById("last-name").value;
        let email = document.getElementById("email").value;
        let password = document.getElementById("password").value;
        let passwordConfirm = document.getElementById("password-confirm").value;

        errors = [];

        //PROVERA
        regexValidation(reFullName, firstName, messageBoxRegister);
        regexValidation(reFullName, lastName, messageBoxRegister);
        regexValidation(reEmail, email, messageBoxRegister);
        regexValidation(rePassword, password, messageBoxRegister);
        regexValidation(rePassword, passwordConfirm, messageBoxRegister);


        if (passwordConfirm != password){
            errors.push("Lozinke se ne poklapaju!");
        }

        if (errors.length > 0){
            messageBoxRegister.innerHTML = "";
            messageBoxRegister.classList.remove("alert-info");
            messageBoxRegister.classList.add("alert-danger");
            messageBoxRegister.classList.remove("mb-d-none");
            messageBoxRegister.classList.add("mb-d-block");

            for (let err in errors) {
                //NO DUPLICATE ERRORS
                if (errors[err] != errors[err-1]) {
                    messageBoxRegister.innerHTML += errors[err] + "<br/>";
                }
            }
        }
        else {
            messageBoxRegister.classList.remove("mb-d-block");
            messageBoxRegister.classList.add("mb-d-none");
            messageBoxRegister.innerHTML = "";

            let data = {
                firstName: firstName,
                lastName: lastName,
                email: email,
                password: password,
                passwordConfirm: passwordConfirm
            };
            ajaxCallback("register.php","post",data,messageBoxRegister, function (result){
                messageBoxRegister.innerHTML = "";
                messageBoxRegister.classList.remove("mb-d-none");
                messageBoxRegister.classList.add("mb-d-block");
                messageBoxRegister.classList.remove("alert-danger");
                messageBoxRegister.classList.add("alert-info");
                messageBoxRegister.innerHTML = result.message;
                window.location.href = "index.php?page=shop";
                if (topNavbar) topNavbar.remove();
            });
        }


    });

    //LOGIN
    $("#mb-form-login").on("submit", function (e){
        e.preventDefault();

        let messageBoxLogin = document.getElementById("mb-login-message");
        let email = document.getElementById("login-email").value;
        let password = document.getElementById("login-password").value;

        errors = [];

        //PROVERA
        regexValidation(reEmail, email, messageBoxLogin);
        regexValidation(rePassword, password, messageBoxLogin);

        if (errors.length > 0){
            messageBoxLogin.innerHTML = "";
            messageBoxLogin.classList.remove("alert-info");
            messageBoxLogin.classList.add("alert-danger");
            messageBoxLogin.classList.remove("mb-d-none");
            messageBoxLogin.classList.add("mb-d-block");

            for (let err of errors) {
                messageBoxLogin.innerHTML += err + "<br/>";
            }
        }
        else {
            messageBoxLogin.classList.remove("mb-d-block");
            messageBoxLogin.classList.add("mb-d-none");
            messageBoxLogin.innerHTML = "";

            let data = {
                loginEmail: email,
                loginPassword: password
            };
            ajaxCallback("login.php","post",data,messageBoxLogin, function (result){
                messageBoxLogin.innerHTML = "";
                messageBoxLogin.classList.remove("mb-d-none");
                messageBoxLogin.classList.add("mb-d-block");
                messageBoxLogin.classList.remove("alert-danger");
                messageBoxLogin.classList.add("alert-info");
                messageBoxLogin.innerHTML = result.message;
                window.location.href = "index.php?page=shop";
                if (topNavbar) topNavbar.remove();
            });
        }
    })

    //CONTACT
    $("#btn-contact").on("click", function (e){
        e.preventDefault();

        let messageBox = document.getElementById("mb-contact-info");
        let name = document.getElementById("contact-name").value;
        let email = document.getElementById("contact-email").value;
        let subject = document.getElementById("contact-subject").value;
        let message = document.getElementById("contact-message").value;

        errors = [];

        regexValidation(reFullName, name, messageBox);
        regexValidation(reEmail, email, messageBox);

        if (subject.length == 0 || message.length == 0) {
            errors.push("Niste uneli sva polja!");
        }

        if (errors.length > 0){
            messageBox.innerHTML = "";
            messageBox.classList.remove("alert-info");
            messageBox.classList.add("alert-danger");
            messageBox.classList.remove("mb-d-none");
            messageBox.classList.add("mb-d-block");

            for (let err of errors) {
                messageBox.innerHTML += err + "<br/>";
            }
        }
        else {
            messageBox.classList.remove("mb-d-block");
            messageBox.classList.add("mb-d-none");
            messageBox.innerHTML = "";

            let data = {
                contactName: name,
                contactEmail: email,
                contactSubject: subject,
                contactMessage: message
            };

            ajaxCallback("contact.php","post",data,messageBox, function (result){
                messageBox.innerHTML = "";
                messageBox.classList.remove("mb-d-none");
                messageBox.classList.add("mb-d-block");
                messageBox.classList.remove("alert-danger");
                messageBox.classList.add("alert-info");
                messageBox.innerHTML = result.message;
            });
        }
    })
    
    //LOAD TABLE
    $(".table-link").on("click", function(e) {
        e.preventDefault();

        let messageBoxInfo = document.getElementById("mb-table-info");
        let messageBoxTable = document.getElementById("mb-table-message");
        let tableSpan = document.getElementById("mb-table-span");

        messageBoxInfo.classList.remove("mb-d-block");
        messageBoxInfo.classList.add("mb-d-none");

        //GET CHOSEN TABLE NAME
        tableName = $(this).data('table');
        tableSpan.textContent = tableName.toUpperCase();

        //DISABLE GENDER INSERTS
        if (tableName == "genders"){
            $("#mb-btn-insert").addClass("mb-disabled");
        }
        else {
            $("#mb-btn-insert").removeClass("mb-disabled");
        }

        let data = {
            table: tableName
        };

        ajaxCallback("table-show.php", "get", data, messageBoxTable, function (result){
            messageBoxTable.innerHTML = "";
            messageBoxTable.classList.remove("mb-d-block");
            messageBoxTable.classList.add("mb-d-none");

            refreshTable(result);
        });
    });

    //INSERT
    $("#mb-btn-insert").on("click", function (e) {
        e.preventDefault();
        if (tableName){
            //DISABLE GENDER INSERTS
            if (tableName != "genders"){
                window.location.href = `index.php?page=insert-${tableName}`;
            }
        }
        else {
            $("#mb-table-info").text("You haven't chosen any table.");
        }
    });

    //ON INSERT PAGE
    $("#btn-insert").on("click", function (e){
        e.preventDefault();
        let messageBox = document.getElementById("mb-insert-info");
        let url = window.location.search;
        url = url.replace("?page=", '');
        messageBox.textContent = "";

        if (url == "insert-articles"){
            let data = {
                name: $("#article-name").val(),
                tag: $("#article-tag").val(),
                IDcat: $("#article-category-select").val()
            }

            //PAGE IN MODELS FOLDER
            ajaxCallback("insert-articles.php", "post", data, messageBox, function (result){
                messageBox.classList.remove("alert-danger");
                messageBox.classList.add("alert-info");
                messageBox.textContent = result.message;
            })
        }
        if (url == "insert-users"){
            let data = {
                firstName: $("#user-first-name").val(),
                lastName: $("#user-last-name").val(),
                email: $("#user-email").val(),
                password: $("#user-password").val(),
                passwordConfirm: $("#user-passwordConfirm").val()
            }

            //PAGE IN MODELS FOLDER
            ajaxCallback("insert-users.php", "post", data, messageBox, function (result){
                messageBox.classList.remove("alert-danger");
                messageBox.classList.add("alert-info");
                messageBox.textContent = result.message;
            })
        }
        if (url == "insert-categories"){
            let data = {
                categoryName: $("#category-name").val()
            };
            ajaxCallback("insert-categories.php","post",data,messageBox,function (result){
                messageBox.classList.remove("alert-danger");
                messageBox.classList.add("alert-info");
                messageBox.textContent = result.message;
            });
        }
        if (url == "insert-articles_genders"){
            let data = {
                IDarticle: $("#ag-article").val(),
                IDgender: $("#ag-gender").val(),
                priceNew: $("#ag-new-price").val(),
                priceOld: $("#ag-old-price").val(),
                description: $("#ag-desc").val(),
                image: $("#ag-img").val()
            };

            ajaxCallback("insert-articles_genders.php","post",data,messageBox,function (result){
                messageBox.classList.remove("alert-danger");
                messageBox.classList.add("alert-info");
                messageBox.textContent = result.message;
            });
        }
    })

    //DELETE USER
    $(document).on("click",".mb-btn-delete", function (e){
        e.preventDefault();
        let hasConfirmed = confirm("Upozorenje! Ova akcija briše izabrani red u bazi zauvek. Ako želite da nastavite sa akcijom, potvrdite klikom na OK.");

        if (hasConfirmed){
            let messageBox = document.getElementById("mb-table-info");

            let IDrow = $(this).data('id');

            let data = {
                tableName: tableName,
                id: IDrow
            };

            ajaxCallback("delete-row.php","post",data, messageBox, function (result){
                // messageBox.classList.remove("mb-d-none");
                // messageBox.classList.add("mb-d-block");
                messageBox.classList.remove("alert-danger");
                messageBox.classList.add("alert-info");
                // messageBox.textContent = result.message;

                //REFRESH TABLE
                refreshTable(result);
            });
        }
    })

    //MODIFY
    $(document).on("click",".mb-btn-edit", function (e){
        e.preventDefault();

        let IDrow = $(this).data('id');

        window.location.href = `index.php?page=edit-${tableName}&id=${IDrow}`;
    });

    //ON MODIFY PAGE
    $("#btn-edit").on("click",function (e){
        e.preventDefault();

        let messageBox = document.getElementById("mb-edit-info");
        let url = window.location.search;
        let variables = url.split("&");
        let page = variables[0].replace("?page=", '');
        let id = variables[1].replace("id=", '');

        messageBox.textContent = "";

        if (page == "edit-users"){
            let data = {
                id: id,
                firstName: $("#user-first-name").val(),
                lastName: $("#user-last-name").val(),
                email: $("#user-email").val(),
                password: $("#user-password").val(),
                passwordConfirm: $("#user-passwordConfirm").val()
            };

            ajaxCallback("edit-users.php","post",data, messageBox, function (result){
                messageBox.classList.remove("alert-danger");
                messageBox.classList.add("alert-info");
                messageBox.textContent = result.message;
                window.location.href = `index.php?page=admin_panel`;
            });
        }
        if (page == "edit-articles") {
            let data = {
                id: id,
                name: $("#article-name").val(),
                tag: $("#article-tag").val(),
                IDcat: $("#article-category-select").val()
            };

            ajaxCallback("edit-articles.php","post",data, messageBox, function (result){
                messageBox.classList.remove("alert-danger");
                messageBox.classList.add("alert-info");
                messageBox.textContent = result.message;
                window.location.href = `index.php?page=admin_panel`;
            });
        }
        if (page == "edit-categories"){
            let data = {
                id: id,
                name: $("#category-name").val(),
            };

            ajaxCallback("edit-categories.php","post",data, messageBox, function (result){
                messageBox.classList.remove("alert-danger");
                messageBox.classList.add("alert-info");
                messageBox.textContent = result.message;
                window.location.href = `index.php?page=admin_panel`;
            });
        }
        if (page == "edit-articles_genders"){
            let data = {
                id: id,
                IDarticle: $("#ag-article").val(),
                IDgender: $("#ag-gender").val(),
                priceNew: $("#ag-new-price").val(),
                priceOld: $("#ag-old-price").val(),
                description: $("#ag-desc").val(),
                image: $("#ag-img").val()
            };

            ajaxCallback("edit-articles_genders.php","post",data,messageBox,function (result){
                messageBox.classList.remove("alert-danger");
                messageBox.classList.add("alert-info");
                messageBox.textContent = result.message;
                window.location.href = `index.php?page=admin_panel`;
            });
        }
    })

    //ON SHOP PAGE
    let url = window.location.search;
    let variables = url.split("&");
    let page = variables[0].replace("?page=", '');
    // let id = variables[1].replace("id=", '');
    // if (window.location.pathname == "/EliteShoppy/index.php"){
    if (page == "shop") {
        let messageBox = document.getElementById("messageBoxShop");
        let container = document.getElementById("articles-container");

        let inputSearch = "";
        let inputPrice = $("#range-price").val(); //string
        let inputSort = "1";
        let inputCategory = $("#input-select-category").val();
        let inputGender = "";

        let data = {
            inputSearch: inputSearch,
            inputPrice: inputPrice,
            inputSort: inputSort,
            inputCategory: inputCategory,
            inputGender: inputGender
        }

        //SEND 1 DEFAULT AJAX FOR FIRST TIME LOADING WITH DEFAULT FILTERS
        ajaxCallback("get-articles.php", "get", data, messageBox, function (result){
            messageBox.classList.remove("mb-d-block");
            messageBox.classList.add("mb-d-none");

            printArticles(result);
        });

        //INPUT SEARCH
        $("#btn-input-search").on("click", function (e){
            e.preventDefault();

            if ($("#input-search").val()){
                data.inputSearch = $("#input-search").val();
            }
            else {
                data.inputSearch = "";
            }

            container.innerHTML = "";
            ajaxCallback("get-articles.php", "get", data, messageBox, function (result){
                messageBox.classList.remove("mb-d-block");
                messageBox.classList.add("mb-d-none");

                printArticles(result);
            });
        });

        // INPUT RANGE
        $("#range-span").text("$" + $("#range-price").val());// first time bind
        $("#range-price").on("change", function (){
            $("#range-span").text("$" + $("#range-price").val());

            data.inputPrice = $("#range-price").val();

            container.innerHTML = "";

            ajaxCallback("get-articles.php", "get", data, messageBox, function (result){
                messageBox.classList.remove("mb-d-block");
                messageBox.classList.add("mb-d-none");

                printArticles(result);
            });
        });

        //INPUT SELECT CATEGORY
        $("#input-select-category").on("change", function (){
            data.inputCategory = $("#input-select-category").val();//value attr

            container.innerHTML = "";

            ajaxCallback("get-articles.php", "get", data, messageBox, function (result){
                messageBox.classList.remove("mb-d-block");
                messageBox.classList.add("mb-d-none");

                printArticles(result);
            });
        });

        //INPUT CHECKBOX GENDERS
        $(".mb-checkbox-gender").on("change", function (){
            if ($(this).is(":checked")){
                data.inputGender = $(this).val(); //value attr

                container.innerHTML = "";

                ajaxCallback("get-articles.php", "get", data, messageBox, function (result){
                    messageBox.classList.remove("mb-d-block");
                    messageBox.classList.add("mb-d-none");

                    printArticles(result);
                });
            }
        });

        //INPUT SELECT SORTS
        $("#input-select-sort").on("change", function (){
           data.inputSort = $("#input-select-sort").val();

            container.innerHTML = "";

            ajaxCallback("get-articles.php", "get", data, messageBox, function (result){
                messageBox.classList.remove("mb-d-block");
                messageBox.classList.add("mb-d-none");

                printArticles(result);
            });
        });
    }
})

function printArticles(result){
    let container = document.getElementById("articles-container");
    let print = '';

    result.forEach(row => {
        print += `
             <div class="col-md-3 product-men">
                <div class="men-pro-item simpleCart_shelfItem">
                    <div class="men-thumb-item">
                        <img src="images/${row.image}" alt="article" class="pro-image-front"/>
                        <img src="images/${row.image}" alt="article" class="pro-image-back"/>
                        <div class="men-cart-pro">
                            <div class="inner-men-cart-pro">
                                <a href="index.php?page=single&id=${row.ag_id}" data-id="${row.ag_id}" class="link-product-add-cart">Quick View</a>
                            </div>
                        </div>
                        <span class="product-new-top ${row.tag ? "" : "mb-d-none"}">${row.tag}</span>
                    </div>
                    <div class="item-info-product ">
                        <h4><a href="index.php?page=single&id=${row.ag_id}">${row.article_name}</a></h4>
                        <div class="info-product-price">
                            <span class="item_price">${row.active_price}</span>
                            <del>${row.old_price}</del>
                        </div>
                        <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out button2">
                            <form id="form-add-cart">
                                <fieldset>
                                    <input type="hidden" name="cmd" value="_cart" />
                                    <input type="hidden" name="add" value="1" />
                                    <input type="hidden" name="business" value=" " />
                                    <input type="hidden" name="item_name" value="A-line Black Skirt" />
                                    <input type="hidden" name="amount" value="30.99" />
                                    <input type="hidden" name="discount_amount" value="1.00" />
                                    <input type="hidden" name="currency_code" value="USD" />
                                    <input type="hidden" name="return" value=" " />
                                    <input type="hidden" name="cancel_return" value=" " />
                                    <input type="submit" name="submit" value="Add to cart" class="button" />
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>`
    })

    container.innerHTML = print;
}

function regexValidation(re, value){
    try {
        if (!re.test(value)) {
            //WHICH REGEX
            if (re === reFullName) {
                throw("Ime i prezime moraju sadržati bar jedno veliko slovo i maksimum 15 malih.")
            }
            else if (re === reEmail) {
                throw("Email nije u dobrom formatu. Primer: username@gmail.com...");
            }
            else if (re === rePassword) {
                throw("Lozinka mora sadržati 8-20 karaktera i to samo slova i brojeve.");
            }
        }
        else {
            return 0;
        }
    }
    catch (err) {
        errors.push(err);
        return 1;
    }
}

function refreshTable(result){
    let table = document.getElementById("mb-table");
    table.innerHTML = "";

    let print = "<thead><tr>";
    let headers = Object.keys(result[0]);
    for (let header of headers) {
        print += `
                            <th>${header}</th>
                          `
    }

    if (tableName != "genders") {
        print += `<th>Modify</th>`
    }
    if (tableName == "users") {
        print += `<th>Delete</th>`
    }
    print += `</tr></thead>`;

    print += "<tbody>";
    result.forEach(obj => {
        print += `<tr>`
        for (let header of headers) {
            print += `<td>${obj[header] != null && obj[header].length>100 ? obj[header].slice(0,100) + '...' : obj[header]}</td>`
        }

        if (tableName != "genders"){
            print += `<td>
                        <button class="btn btn-warning mb-btn-edit" data-id="${obj.id}">
                            <span>Edit</span>
                        </button></td>`;
        }
        if (tableName == "users"){
            print += `<td><button class="btn btn-danger mb-btn-delete" data-id="${obj.id}">
                                <span>Delete</span>
                            </button></td>`;
        }
        print += `</tr>`;
    })
    print += "</tbody>";
    table.innerHTML = print;
}

function ajaxCallback(page, method, objData, messageBox, result) {
    objData = objData == 0 ? "" : objData;

    $.ajax({
        url: "models/" + page,
        method: method,
        data: objData,
        dataType: "json",
        success: result,
        error: function (xhr) {
            let errors = xhr.responseJSON.errors;
            messageBox.innerHTML = "";
            if (errors.length>0){
                messageBox.classList.remove("mb-d-none");
                messageBox.classList.add("mb-d-block");
                messageBox.classList.remove("alert-info");
                messageBox.classList.add("alert-danger");

                for (let error of errors) {
                    messageBox.innerHTML += error + "<br/>";
                }
            }
            else {
                messageBox.classList.remove("mb-d-block");
                messageBox.classList.add("mb-d-none");
                messageBox.innerHTML = "";
            }
            // console.log(xhr);
            // console.log(status);
        }
    });
}