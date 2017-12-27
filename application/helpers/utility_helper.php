<?php

function get_asset_url(){
   return base_url().'assets/';
}

function asset_url(){
   echo base_url().'assets/';
}

function get_upload_url(){
   return base_url().'uploads/'; 
}
function get_image_src($fileName){
   return base_url()."uploads/{$fileName}"; 
}
