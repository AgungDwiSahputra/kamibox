<?php
	

    function generate_otp($email){
		include 'connect_db.php';

        $generate_otp = mt_rand(1000,9999);
        $_SESSION['kode_otp'] = $generate_otp;

        //input data otp ke database
         $insert_otp = mysqli_query($conn,"insert into kode_otp (email_user, kodeotp, active) values ('$email', '$generate_otp', 'Y') ");
        

         if($insert_otp){
            $select_id_otp = mysqli_query($conn, "select id_kodeotp from kode_otp order by id_kodeotp desc limit 1;" ); 
            
            if($select_id_otp == true){

                $data = mysqli_fetch_assoc($select_id_otp);
                $_SESSION['idotp'] = $data['id_kodeotp']; 
                
                //echo "id = ".$_SESSION['idotp'];
                //echo "<br/>sukses otp";

                //jikas success insert otp return id otepe
                return $data['id_kodeotp'];
            }else{
                echo "gagal id otp";
            }
         }else{
            echo "gagal insert_otp";
         }        	
	}

?>

