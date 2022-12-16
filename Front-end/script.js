const base_URL = "http://localhost/FullStackProject-Web/Back%20End/";
const base_HTML = "http://localhost/FullStackProject-Web/Front%20End/";

const workshop_pages = {};
 

workshop_pages.loadFor = (page) => {
    eval("workshop_pages.load_" + page + "();");
}

workshop_pages.load_register = () => {
    const btn_signup = document.getElementById('btn_signup');
    let input_FName_register = document.getElementById('input_FName_register');
    let input_LName_register = document.getElementById('input_LName_register');
    let input_Username_register = document.getElementById('input_Username_register');
    let input_Password_register = document.getElementById('input_Password_register');
    let input_PasswordConf_register = document.getElementById('input_PasswordConf_register');
    let check_register = document.getElementById('check_register');

    const register = async () => {

        let list_register = {};
        console.log(input_Password_register.value, input_PasswordConf_register.value)
        if(input_Password_register.value != input_PasswordConf_register.value){
            check_register.innerHTML = "Password and password confirmation do not match"
        }
        else if(input_FName_register.value =='' || 
                input_LName_register.value =='' ||
                input_Username_register.value =='' ||
                input_Password_register.value =='' ||
                input_PasswordConf_register.value =='' ){
                    
                    check_register.innerHTML = "Please fill all the empty fields"
        }
        else{
            var bodyFormData = new FormData();
            bodyFormData.append('FName', input_FName_register.value);
            bodyFormData.append('LName', input_LName_register.value);
            bodyFormData.append('Username', input_Username_register.value);
            bodyFormData.append('Password', input_Password_register.value);

            await axios({
                method: "post",
                url: base_URL + "register.php",
                data: bodyFormData,
                headers: { "Content-Type": "multipart/form-data" },
              })
            .then(function(response){
                list_register = response.data;
            })
            .catch(function(error) {
                console.log(error);
            });    
            if(list_register["success"] == "user_already_exit"){
                check_register.innerHTML = "This user already exist please enter a different username"
            }
            else{
                location.replace(base_HTML+"login.html");
            }

        };  
    }
    btn_signup.addEventListener('click', register);

}
workshop_pages.load_login = () => {
    const btn_login = document.getElementById('btn_login');
    let input_username = document.getElementById('input_username');
    let input_pass = document.getElementById('input_pass');

    const login = async () => {//login post user name and password returns all info needed about the username 
        let list_login = {};
        var bodyFormData = new FormData();
        bodyFormData.append('email', input_username.value);
        bodyFormData.append('password', input_pass.value);
        await axios({
            method: "post",
            //url: "http://localhost/FullStackProject-Web/Back%20End/login.php",
            url:"http://localhost:8000/api/login",
            data: bodyFormData,
            headers: { "Content-Type": "multipart/form-data" },
          })
        .then(function(response){
            const test = response;
             list_login = response.data;
             console.log(test)
        })
        .catch(function(error) {
            console.log(error);
        });     
        if(list_login["success"] == "true"){
            //adding values to local stoarge
            localStorage.setItem("FName", list_login["0"]["FName"]);
            localStorage.setItem("LName", list_login["0"]["LName"]);
            localStorage.setItem("Username", list_login["0"]["Username"]);
            localStorage.setItem("User_id", list_login["0"]["User_id"]);
            //moving to homepage
            //location.replace(base_HTML+"homePage.html");
        }
        else{
            document.getElementById("check").innerHTML = "Wrong username or password";
        }
    };  
    btn_login.addEventListener('click', login);
}
workshop_pages.load_editProfile = () => {
    const btn_editProfile = document.getElementById('btn_editProfile');

    let input_FName_edit = document.getElementById('input_FName_edit');
    let input_LName_edit = document.getElementById('input_LName_edit');
    let input_Username_edit = document.getElementById('input_Username_edit');
    let input_PasswordNew_edit = document.getElementById('input_PasswordNew_edit');
    let input_PasswordConf_edit = document.getElementById('input_PasswordConf_edit');

    let check_editProfile = document.getElementById('check_editProfile');

    const editProfile = async () => {

        let list_register = {};
        if(input_PasswordNew_edit.value != input_PasswordConf_edit.value){
            check_register.innerHTML = "Password and password confirmation do not match"
        }
        else if(input_FName_edit.value =='' || 
                input_LName_edit.value =='' ||
                input_Username_edit.value =='' ||
                input_PasswordNew_edit.value =='' ||
                input_PasswordConf_edit.value =='' ){
                check_editProfile.innerHTML = "Please fill all the empty fields"
        }
        else{
            var bodyFormData = new FormData();
            bodyFormData.append('User_id', localStorage.getItem("User_id"));
            bodyFormData.append('FName', input_FName_edit.value);
            bodyFormData.append('LName', input_LName_edit.value);
            bodyFormData.append('Username', input_Username_edit.value);
            bodyFormData.append('Password', input_PasswordNew_edit.value);

            await axios({
                method: "post",
                url: base_URL + "edit_profile.php",
                data: bodyFormData,
                headers: { "Content-Type": "multipart/form-data" },
              })
            .then(function(response){
                list_register = response.data;
            })
            .catch(function(error) {
                console.log(error);
            });    
            if(list_register["success"] == "user_already_exit"){
                check_editProfile.innerHTML = "This username already exist please enter a different username"
            }
            else{
                location.replace(base_HTML+"accountView.html");
            }
        };  
    }
    btn_editProfile.addEventListener('click', editProfile);

}
workshop_pages.load_post = () => {
    const btn_addImage = document.getElementById('btn_addImage');
    const input_addImage_URL = document.getElementById('input_addImage_URL');
    const check_addPost = document.getElementById('check_addPost')

    const postImage = async () => {
        if(input_addImage_URL.value == ''){
            check_addPost.innerHTML = "Please enter the image URL";
        }
        else{
        let list_post = {};
        var bodyFormData = new FormData();
        bodyFormData.append('User_id', localStorage.getItem("User_id"));
        bodyFormData.append('Image_URL', input_addImage_URL.value);
        await axios.get({
            method: "post",
            url: "http://localhost/FullStackProject-Web/Back%20End/add_post.php",
            data: bodyFormData,
            headers: { "Content-Type": "multipart/form-data" },
          })
        .then(function(response){
            list_post = response.data;
        })
        .catch(function(error) {
            console.log(error);
        });     
        if(list_post["success"] == "true"){
            console.log(list_post)
            //adding values to local stoarge
            check_addPost.innerHTML = "Post has been submmitted, add new one?"
        }
        };  
    }
btn_addImage.addEventListener('click', postImage);

}
workshop_pages.load_block = () => {
    const btn_block = document.getElementById('btn_block');
    const input_username_block = document.getElementById('input_username_block');
    const check_block_list = document.getElementById('check_block_list');
    const check_block = document.getElementById('check_block');

    let list_blocks = {};
    let list_username_blocks=[];
    let list_username_id=[];
    //========================================================================
    const blockUser = async () => {
        if(input_username_block.value == ''){
            check_block.innerHTML = "Please enter a valid username";
        }
        else{
        let list_post = {};
        var bodyFormData = new FormData();
        bodyFormData.append('User1_id', localStorage.getItem("User_id"));
        bodyFormData.append('User2_id', input_addImage_URL.value);
        await axios({
            method: "post",
            url: "http://localhost/FullStackProject-Web/Back%20End/add_post.php",
            data: bodyFormData,
            headers: { "Content-Type": "multipart/form-data" },
          })
        .then(function(response){
            list_post = response.data;
        })
        .catch(function(error) {
            console.log(error);
        });     
        if(list_post["success"] == "true"){
            console.log(list_post)
            //adding values to local stoarge
            check_addPost.innerHTML = "Post has been submmitted, add new one?"
        }
        };  
    }
   // btn_block.addEventListener('click', blockUser);


    //========================================================================
    let username ="";
    //=====================================
    //        getting blockList
    //=====================================
    const get_blocks = async () => {
        const response = await axios.get(
            base_URL + "get_blocks.php"+ "?User1_id="+localStorage.getItem("User_id")
            );

        list_blocks =  response.data;
        for(let i =0; i< list_blocks.length+1;i++)
        {
            console.log(list_blocks["0"][""+ i +""]["User2_id"]);
            list_username_id.push(list_blocks["0"][""+ i +""]["User2_id"])
        }
       // console.log(list_username_id);
    };

    const get_username = async (user_id) => {
        const response = await axios.get(
            base_URL + "get_username.php"+ "?User_id="+user_id
            );

        username =  response.data["0"]["Username"];




        console.log(username)
        check_block_list.innerHTML= `<p>`+username+`</p>`; //add for loop to go through all the usernames (until await async work)

    };
    //=====================================
    //        blocking a new user
    //=====================================

}    
// block.html
// addPost
workshop_pages.load_homePage = async () => {
    class images {
        constructor(User_id, Image_URL, Image_id, likes) {
          this.User_id = User_id;
          this.Image_URL = Image_URL;
          this.Image_id = Image_id;
          this.likes = likes;
        }
    }

    let list_get_images = {};


    const get_images = async() => {
            await axios.get(base_URL + "get_images.php").then( response =>{
            list_get_images =  response.data;
            console.log(list_get_images)

        })
    };

    const get_images_async = async () => {
        const response = await axios.get(
            base_URL + "get_images.php"
        );
    
        list_get_images =  response.data;
        console.log(list_get_images)
    };


    await get_images();
    
    //we need user_id so we can post their name
    //get_images --> return image URL + image id
    //get_likes (after retrieving the image_id)
    console.log(list_get_images)

    console.log(list_get_images["4"]["Image_URL"])

    const posts = document.getElementById('elements');
    const append = '<div id="elements">'+
    '<div class="grid-item">'+
        '<div class="card">'+
            '<img class="card-img" src="'+ list_get_images["4"]["Image_URL"] +'" />'+
            '<div class="card-content">'+
                '<h1 class="card-header">Orange </h1>'+
                '<button id="btn_comment" class="card-btn comment">Comments <button id="btn_like"'+
                        'class="card-btn like">Likes 0 </button> </button>'+
                '</div>'+
            '</div>'+
        '</div>'+
    '</div>'

    const append2 = '<div id="elements">'+
    '<div class="grid-item">'+
        '<div class="card">'+
            '<img class="card-img" src="img2.jpg" />'+
            '<div class="card-content">'+
                '<h1 class="card-header">Orange </h1>'+
                '<button id="btn_comment" class="card-btn comment">Comments <button id="btn_like"'+
                        'class="card-btn like">Likes 0 </button> </button>'+
                '</div>'+
            '</div>'+
        '</div>'+
    '</div>'

    const list2 = [append + append2]
    posts.innerHTML = list2;
}


