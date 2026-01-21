<?php
$site_url = url().'/public';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Neopaed</title> 
    <style>
        body{
        
    position: relative;
    width: 15cm;
    height: 10cm;
    margin: 0 auto;
    color: #001028;
    background: #FFFFFF;
    font-family: Arial, sans-serif;
    font-size: 12px;
    font-family: Arial;
        }
        header {
    padding: 20px 0;
    margin-bottom: 30px;
}  
hr.line {
   
   width:840px;
    margin-top: 610px;
   
}
 </style>
</head>
<body>
    <header>
        <img src="{{ ValuelistHelpers::printPagelogo() }}" alt="Logo"  height="150px">                
        <hr>                        
    </header>
   <section>   
    @yield('content')
    Thanks,
    Regards,
   </section>
    <footer>                         
        <hr class="line">                    
        <img src="{{ $site_url }}/img/emails/company_logo.jpg"  style= "padding-left:390px;width:60px;height:70px;"/>                                 
        <center> &copy; copyright 2017.<center>      
    </footer>               
</body>
</html>  

          

