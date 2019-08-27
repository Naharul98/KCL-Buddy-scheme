function removeMultipeSelectorIfSuperAdmin(){
  if($("#cmb_profile").val()=="super_admin"){
    document.getElementById("multiple_selector").style.display = "none";
  }else{
    document.getElementById("multiple_selector").style.display = "flex";
  }
}
removeMultipeSelectorIfSuperAdmin();
