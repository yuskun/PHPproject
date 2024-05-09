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

