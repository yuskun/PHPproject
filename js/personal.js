const personal=document.querySelector("#personal");
const inform=document.querySelector("#inform");
const private=document.querySelector("#private");
const personalBOX=document.querySelector("#personalBOX");
const informBOX=document.querySelector("#informBOX");
const privateBOX=document.querySelector("#privateBOX");
function closepersonal(){
   if(personalBOX.style.height==="0px"){
     personalBOX.style.height="40vh"

   }
   else{
      personalBOX.style.height="0"
   }
 

}
function closeinform(){
 
   if( informBOX.style.height==="0px"){
      informBOX.style.height="20vh"

 
   }else{
      informBOX.style.height="0"
   }
   
   

}

function closeprivate(){
 
   if( privateBOX.style.height==="0px"){
      privateBOX.style.height="20vh"

 
   }else{
      privateBOX.style.height="0"
   }
   
   

}
function previewAvatar() {
   const file = document.getElementById('avatarInput').files[0];
   const reader = new FileReader();
   reader.onloadend = function () {
       document.getElementById('avatarImage').src = reader.result;
       document.getElementById('profile_picture_base64').value = reader.result;
   }
   if (file) {
       reader.readAsDataURL(file);
   }
}

function cancelChanges() {
   // Add your logic to reset or cancel changes
   alert('取消更改');
}
function openModal() {
   document.getElementById('resetPasswordModal').style.display = 'block';
}

function closeModal() {
   document.getElementById('resetPasswordModal').style.display = 'none';
}

function cancelChanges() {
   // 在這裡添加取消變更的邏輯
}

window.onclick = function(event) {
   const modal = document.getElementById('resetPasswordModal');
   if (event.target == modal) {
       modal.style.display = 'none';
   }
}

