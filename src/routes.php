<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header("Content-type:application/json",true);


//login parent
$app->get('/parLogin/[user={par_user}&&pass={par_password}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM parent2 WHERE par_user=:par_user and par_password=:par_password");
    $sth->bindParam("par_user", $args['par_user']);
    $sth->bindParam("par_password", $args['par_password']);
    $sth->execute();
    $todos = $sth->fetch();   
    return $this->response->withJson($todos);
});

    // parentall
$app->get('/parentall/[user={par_user}&&pass={par_password}]', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM parent2  WHERE par_user=:par_user and par_password=:par_password");
        $sth->bindParam("par_user", $args['par_user']);
        $sth->bindParam("par_password", $args['par_password']);
        $sth->execute();
        $todos = $sth->fetch();   
        return $this->response->withJson($todos);
});

       // edit parent 
$app->any('/editparent22/[{par_id}&&{par_title}&&{par_name}&&{par_sname}&&{par_tel}]',function ($request, $response, $args){
    $sql = "UPDATE parent2 SET par_title=:par_title,par_name=:par_name,par_sname=:par_sname,par_tel=:par_tel WHERE par_id=:par_id";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("par_id", $args['par_id']);
    $sth->bindParam("par_title", $args['par_title']);
    $sth->bindParam("par_name", $args['par_name']);
    $sth->bindParam("par_sname", $args['par_sname']);
    $sth->bindParam("par_tel", $args['par_tel']);
    if($sth->execute()==true){
        $status = 'Success';
    }else{
        $status = 'Error';
    }
    return $this->response->withJson($status);

});

      // edit parent lat&long
$app->any('/editparentlatlong/[{par_id}&&{latitude}&&{longitude}]',function ($request, $response, $args){
    $sql = "UPDATE parent2 SET latitude=:latitude,longitude=:longitude WHERE par_id=:par_id";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("par_id", $args['par_id']);
    $sth->bindParam("latitude", $args['latitude']);
    $sth->bindParam("longitude", $args['longitude']);
    if($sth->execute()==true){
        $status = 'Success';
    }else{
        $status = 'Error';
    }
    return $this->response->withJson($status);

});
      // edit parent lat&long
$app->any('/editteacherlatlong/[{teacher_id}&&{teacher_latitude}&&{teacher_longitude}]',function ($request, $response, $args){
    $sql = "UPDATE teacher2 SET teacher_latitude=:teacher_latitude,teacher_longitude=:teacher_longitude WHERE teacher_id=:teacher_id";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("teacher_id", $args['teacher_id']);
    $sth->bindParam("teacher_latitude", $args['teacher_latitude']);
    $sth->bindParam("teacher_longitude", $args['teacher_longitude']);
    if($sth->execute()==true){
        $status = 'Success';
    }else{
        $status = 'Error';
    }
    return $this->response->withJson($status);

});

     // edit parent lat&longNull
$app->any('/editparentlatlongNull/[{par_id}&&{latitude}&&{longitude}]',function ($request, $response, $args){
    $sql = "UPDATE parent2 SET latitude=:latitude,longitude=:longitude WHERE par_id=:par_id";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("par_id", $args['par_id']);
    $sth->bindParam("latitude", $args['latitude']);
    $sth->bindParam("longitude", $args['longitude']);
    if($sth->execute()==true){
        $status = 'Success';
    }else{
        $status = 'Error';
    }
    return $this->response->withJson($status);

});
/////////////////////////////////////////////////////////////////////////// teacher app
// get all mainparent 
    $app->get('/allparent/{teacher_id}', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT * FROM `parent2` WHERE parent2.teacher_id =:teacher_id  ORDER  BY parent2.par_name ASC");
         $sth->bindParam("teacher_id", $args['teacher_id']);
         $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });

// get all checkdate 
    $app->get('/allcheckdate/[{teacher_id}]', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT * FROM `checkdate2` WHERE checkdate2.teacher_id =:teacher_id ORDER BY check_id DESC ");
         $sth->bindParam("teacher_id", $args['teacher_id']);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });

// get all mainparent 
    $app->get('/checkparentparid/[{par_id}]', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT * FROM parent2 where par_id=:par_id ");
         $sth->bindParam("par_id", $args['par_id']);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });
// get all mainparent 
$app->get('/checkparent2/{par_user}&&{teacher_id}', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM parent2 WHERE par_user=:par_user and teacher_id=:teacher_id");
    $sth->bindParam("par_user", $args['par_user']);
    $sth->bindParam("teacher_id", $args['teacher_id']);
    // $sth->bindParam("tpassword", $args['tpassword']);
    $sth->execute();
    $par_user = $sth->fetch();   
    return $this->response->withJson($par_user);
});
// get all checkname from date 
    $app->get('/checknamefromdate/{ck_date}&&{class_id}', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT * FROM `checkstudentname2`,`classroom2`,`student2`,`checkdate2` WHERE  checkstudentname2.st_id = student2.st_id  
         AND checkstudentname2.ck_date = checkdate2.check_data and  student2.class_id = classroom2.class_id and checkstudentname2.ck_date=:ck_date and classroom2.class_id=:class_id ORDER BY student2.student_name ASC ");
         $sth->bindParam("ck_date", $args['ck_date']);
         $sth->bindParam("class_id", $args['class_id']);
        //  $sth->bindParam("class_id", $args['class_id']);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });
// get all mainparent 
    $app->get('/classid/[{class_id}]', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT * FROM classroom2 where classroom2.class_id=:class_id");
         $sth->bindParam("class_id", $args['class_id']);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });
// get all mainparent 
    $app->get('/checkclassname/[{class_name}]', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT * FROM classroom2 where class_name=:class_name");
         $sth->bindParam("class_name", $args['class_name']);
        $sth->execute();
        $classname = $sth->fetchAll();
        return $this->response->withJson($classname);
    });
// get all mainparent  checkdate2 
    $app->get('/allcheckstudentname2', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT * FROM checkstudentname2 ");
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });
// get all checkstudentname2  
    $app->get('/checks', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT * FROM checkstudentname2 ");
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });
// get all checkstudentname2  
    $app->get('/f/[{st_id}&&{par_user}]', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT * FROM checkstudentname2,parent2  WHERE checkstudentname2.st_id =:st_id  
                                    and checkstudentname2.par_user= parent2.par_user and parent2.par_user =:par_user");
         $sth->bindParam("st_id", $args['st_id']);
         $sth->bindParam("par_user", $args['par_user']);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });
// get all studentandparent where class_id 
    $app->get('/standparedit/[{idclass}&&{paruser}&&{st_id}]', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM student2,parent2 WHERE student2.par_user = parent2.par_user AND student2.class_id = :idclass AND student2.st_id =:st_id AND parent2.par_user=:paruser");
        $sth->bindParam("idclass", $args['idclass']);
        $sth->bindParam("paruser", $args['paruser']);
        $sth->bindParam("paruser", $args['paruser']);
        $sth->bindParam("st_id", $args['st_id']);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });
// // get all studentandparent where class_id 
//     $app->get('/standparedit/[{idclass}&&{paruser}]', function ($request, $response, $args) {
//         $sth = $this->db->prepare("SELECT * FROM student2,parent2 WHERE student2.par_user = parent2.par_user AND student2.class_id = :idclass AND parent2.par_user=:paruser");
//         $sth->bindParam("idclass", $args['idclass']);
//         $sth->bindParam("paruser", $args['paruser']);
//         $sth->execute();
//         $todos = $sth->fetchAll();
//         return $this->response->withJson($todos);
//     });
// get all parentandstudent
    $app->get('/parentandstudent/{idclass}', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT * FROM student2,parent2 WHERE student2.par_user = parent2.par_user AND student2.class_id = :idclass ORDER BY student2.student_name ASC");
         $sth->bindParam("idclass", $args['idclass']);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });
// get all mainparent
    $app->get('/allclass/{teacher_id}', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM `classroom2`where classroom2.teacher_id=:teacher_id ORDER BY `class_name` ASC");
        $sth->bindParam("teacher_id", $args['teacher_id']);
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });
// get all mainstudent
    $app->get('/studentandparent', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT * FROM `student`,`parents` WHERE parents.pr_user = student.pr_user");
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });
    //get all student
    $app->get('/student/{pr_user}', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM `student`,`parents` WHERE student.pr_user = parents.pr_user AND student.pr_user  = :pr_user ");
        $sth->bindParam("pr_user", $args['pr_user']);
       $sth->execute();
       $todos = $sth->fetchAll();
       return $this->response->withJson($todos);
   });
   // edit student 
   $app->any('/editst/[{s_id}&&{st_title}&&{st_name}&&{st_lassname}&&{st_class}&&{pr_user}]',function ($request, $response, $args){
    $sql = "UPDATE student SET st_title=:st_title,st_name=:st_name,st_lassname=:st_lassname,st_class=:st_class,pr_user=:pr_user  WHERE s_id=:s_id";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("s_id", $args['s_id']);
    $sth->bindParam("st_title", $args['st_title']);
    $sth->bindParam("st_name", $args['st_name']);
    $sth->bindParam("st_lassname", $args['st_lassname']);
    $sth->bindParam("st_class", $args['st_class']);
    $sth->bindParam("pr_user", $args['pr_user']);
    if($sth->execute()){
        $status = 'Success';
    }else{
        $status = 'Error';
    }
    return $this->response->withJson($status);

    });
   // save edit class 
   $app->any('/saveeditclass/[{class_id}&&{class_name}]',function ($request, $response, $args){
    $sql = "UPDATE classroom2 SET class_name=:class_name  WHERE class_id=:class_id";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("class_id", $args['class_id']);
    $sth->bindParam("class_name", $args['class_name']);

    if($sth->execute()){
        $status = 'Success';
    }else{
        $status = 'Error';
    }
    return $this->response->withJson($status);

    });
   // edit student 2
   $app->any('/editsts/[{s_id}&&{st_title}&&{st_name}&&{st_lassname}&&{st_class}&&{pr_user}]',function ($request, $response, $args){
    $sql = "UPDATE student SET st_title=:st_title,st_name=:st_name,st_lassname=:st_lassname,st_class=:st_class,pr_user=:pr_user  WHERE s_id=:s_id";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("s_id", $args['s_id']);
    $sth->bindParam("st_title", $args['st_title']);
    $sth->bindParam("st_name", $args['st_name']);
    $sth->bindParam("st_lassname", $args['st_lassname']);
    $sth->bindParam("st_class", $args['st_class']);
    $sth->bindParam("pr_user", $args['pr_user']);
    if($sth->execute()){
        $status = 'Success';
    }else{
        $status = 'Error';
    }
    return $this->response->withJson($status);

    });
   // edit parent 
   $app->any('/editparent/[{p_id}&&{pr_title}&&{pr_name}&&{pr_lassname}&&{pr_address}&&{pr_phone}]',function ($request, $response, $args){
    $sql = "UPDATE parents SET pr_title=:pr_title,pr_name=:pr_name,pr_lassname=:pr_lassname,pr_address=:pr_address,pr_phone=:pr_phone  WHERE p_id=:p_id";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("p_id", $args['p_id']);
    $sth->bindParam("pr_title", $args['pr_title']);
    $sth->bindParam("pr_name", $args['pr_name']);
    $sth->bindParam("pr_lassname", $args['pr_lassname']);
    $sth->bindParam("pr_address", $args['pr_address']);
    $sth->bindParam("pr_phone", $args['pr_phone']);
    if($sth->execute()){
        $status = 'Success';
    }else{
        $status = 'Error';
    }
    return $this->response->withJson($status);

    });
    // edit teacher 
   $app->any('/editteacher/[{teacher_id}&&{teacher_title}&&{teacher_name}&&{teacher_sname}&&{teacher_address}&&{teacher_tel}]',function ($request, $response, $args){
    $sql = "UPDATE teacher2 SET teacher_title=:teacher_title,teacher_name=:teacher_name,teacher_sname=:teacher_sname,teacher_address=:teacher_address,teacher_tel=:teacher_tel  WHERE teacher_id=:teacher_id";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("teacher_id", $args['teacher_id']);
    $sth->bindParam("teacher_title", $args['teacher_title']);
    $sth->bindParam("teacher_name", $args['teacher_name']);
    $sth->bindParam("teacher_sname", $args['teacher_sname']);
    $sth->bindParam("teacher_address", $args['teacher_address']);
    $sth->bindParam("teacher_tel", $args['teacher_tel']);
    if($sth->execute()==true){
        $status = 'Success';
    }else{
        $status = 'Error';
    }
    return $this->response->withJson($status);

    });
    // edit student
   $app->any('/editstudent2/[{st_id}&&{student_title}&&{student_name}&&{student_sname}&&{student_nickname}&&{student_sex}]',function ($request, $response, $args){
    $sql = "UPDATE student2 SET  student_title=:student_title,student_name=:student_name,student_sname=:student_sname,student_nickname=:student_nickname,student_sex=:student_sex WHERE st_id=:st_id";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("st_id", $args['st_id']);
    $sth->bindParam("student_title", $args['student_title']);
    $sth->bindParam("student_name", $args['student_name']);
    $sth->bindParam("student_sname", $args['student_sname']);
    $sth->bindParam("student_nickname", $args['student_nickname']);
    $sth->bindParam("student_sex", $args['student_sex']);

    if($sth->execute()){
        $status = 'Success';
    }else{
        $status = 'Error';
    }
    return $this->response->withJson($status);

    });

    // setting student
    $app->any('/settingstudent2/[{ck_id}&&{st_id}&&{ck_date}&&{ck_study}&&{ck_receive}&&{ck_other}]',function ($request, $response, $args){
    $sql = "UPDATE checkstudentname2 SET st_id=:st_id,ck_date=:ck_date,ck_study=:ck_study,ck_receive=:ck_receive,ck_other=:ck_other WHERE ck_id=:ck_id";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("ck_id", $args['ck_id']);
    $sth->bindParam("st_id", $args['st_id']);
    $sth->bindParam("ck_date", $args['ck_date']);
    $sth->bindParam("ck_study", $args['ck_study']);
    $sth->bindParam("ck_receive", $args['ck_receive']);
    $sth->bindParam("ck_other", $args['ck_other']);
   

    if($sth->execute()){
        $sstt = 'Success';
    }else{
        $sstt = 'Error';
    }
    return $this->response->withJson($sstt);

    });
    // edit parent
   $app->any('/editparent2/[{par_id}&&{par_user}&&{par_title}&&{par_name}&&{par_sname}&&{par_tel}&&{par_address}]',function ($request, $response, $args){
    $sql = "UPDATE parent2 SET par_user=:par_user,par_title=:par_title,par_name=:par_name,par_sname=:par_sname,par_tel=:par_tel,par_address=:par_address WHERE par_id=:par_id";
    $sth = $this->db->prepare($sql);
    $sth->bindParam("par_id", $args['par_id']);
    $sth->bindParam("par_user", $args['par_user']);
    $sth->bindParam("par_title", $args['par_title']);
    $sth->bindParam("par_name", $args['par_name']);
    $sth->bindParam("par_sname", $args['par_sname']);
    $sth->bindParam("par_tel", $args['par_tel']);
    $sth->bindParam("par_address", $args['par_address']);

    if($sth->execute()){
        $status = 'Success';
    }else{
        $status = 'Error';
    }
    return $this->response->withJson($status);

    });


       // register
       $app->post('/register', function ($request, $response) {
        $input = $request->getParsedBody();
        $sql = "INSERT INTO teacher2( teacher_user,teacher_password,teacher_title,teacher_name,teacher_sname,teacher_address,teacher_tel,teacher_latitude,teacher_longitude) 
        VALUES (:teacher_user,:teacher_password,:teacher_title,:teacher_name,:teacher_sname,:teacher_address,:teacher_tel,:teacher_latitude,:teacher_longitude)";
         $sth = $this->db->prepare($sql);
        $sth->bindParam("teacher_user", $input['teacher_user']);
        $sth->bindParam("teacher_password", $input['teacher_password']);
        $sth->bindParam("teacher_title", $input['teacher_title']);
        $sth->bindParam("teacher_name", $input['teacher_name']);
        $sth->bindParam("teacher_sname", $input['teacher_sname']);
        $sth->bindParam("teacher_address", $input['teacher_address']);
        $sth->bindParam("teacher_tel", $input['teacher_tel']);
        $sth->bindParam("teacher_latitude", $input['teacher_latitude']);
        $sth->bindParam("teacher_longitude", $input['teacher_longitude']);
        
        $input['id'] = $this->db->lastInsertId();
        if ($sth->execute()){
            $err = "Success";
        }else{
            $err = "Fail";
        }
        return $this->response->withJson($err);
    });
        // setting student 
        $app->post('/addsettingstudent2',function ($request, $response, $args){
            $input = $request->getParsedBody();
            $sql = "INSERT INTO checkstudentname2 (ck_date,ck_other,ck_receive,ck_study,st_id) 
            VALUES (:ck_date,:ck_other,:ck_receive,:ck_study,:st_id)";
            $sth = $this->db->prepare($sql);
             $sth->bindParam("ck_date", $input['ck_date']);
            $sth->bindParam("ck_other", $input['ck_other']);
            $sth->bindParam("ck_receive", $input['ck_receive']);
            $sth->bindParam("ck_study", $input['ck_study']);
            $sth->bindParam("st_id", $input['st_id']);
            
            // $input['id'] = $this->db->lastInsertId();
            if( $sth->execute()){
                $callback = array(
                    status => 200,
                    msg => 'Insert success'
                );
            }else{
                $callback = array(
                    'status' => 404,
                    'msg' => 'Insert Fail'
                );
            }
            return $this->response->withJson($callback);
        
            });
       // registerparent
       $app->post('/registerparent2', function ($request, $response) {
        $input = $request->getParsedBody();
        $sql = "INSERT INTO parent2(par_user,par_password,par_title,par_name,par_sname,par_tel,par_address,latitude,longitude,teacher_id) 
        VALUES (:par_user,:par_password,:par_title,:par_name,:par_sname,:par_tel,:par_address,:latitude,:longitude,:teacher_id)";
         $sth = $this->db->prepare($sql);
        $sth->bindParam("par_user", $input['par_user']);
        $sth->bindParam("par_password", $input['par_password']);
        $sth->bindParam("par_title", $input['par_title']);
        $sth->bindParam("par_name", $input['par_name']);
        $sth->bindParam("par_sname", $input['par_sname']);
        $sth->bindParam("par_tel", $input['par_tel']);
        $sth->bindParam("par_address", $input['par_address']);
        $sth->bindParam("latitude", $input['latitude']);
        $sth->bindParam("longitude", $input['longitude']);
        $sth->bindParam("teacher_id", $input['teacher_id']);
        
        $input['id'] = $this->db->lastInsertId();
        if ($sth->execute()){
            $err = "Success";
        }else{
            $err = "Fail";
        }
        return $this->response->withJson($err);
    });


       // register
       $app->post('/addclass', function ($request, $response) {
        $input = $request->getParsedBody();
        $sql = "INSERT INTO classroom2 (class_name,teacher_id)VALUES(:class_name,:teacher_id)";
         $sth = $this->db->prepare($sql);
        $sth->bindParam("class_name", $input['class_name']);
        $sth->bindParam("teacher_id", $input['teacher_id']);
        
        $input['id'] = $this->db->lastInsertId();
        if ($sth->execute()){
            $err = "Success";
        }else{
            $err = "Fail";
        }
        return $this->response->withJson($err);
    });
       // register
       $app->post('/adddate2', function ($request, $response) {
        $input = $request->getParsedBody();
        $sql = "INSERT INTO checkdate2( check_data,teacher_id)VALUES (:check_data,:teacher_id)";
         $sth = $this->db->prepare($sql);
        $sth->bindParam("check_data", $input['check_data']);
        $sth->bindParam("teacher_id", $input['teacher_id']);
        
        $input['id'] = $this->db->lastInsertId();
        if( $sth->execute()){
            $callback = array(
                status => 200,
                msg => 'Insert success'
            );
        }else{
            $callback = array(
                'status' => 404,
                'msg' => 'Insert Fail'
            );
        }
        return $this->response->withJson($callback);
    });
    ////
       $app->post('/addstudent2', function ($request, $response) {
        $input = $request->getParsedBody();
        $sql = "INSERT INTO student2( student_title,student_name,student_sname,student_nickname,student_sex,class_id,par_user)
                VALUES (:student_title, :student_name,:student_sname,:student_nickname,:student_sex,:class_id,:par_user)";
         $sth = $this->db->prepare($sql);
        $sth->bindParam("student_title", $input['student_title']);
        $sth->bindParam("student_name", $input['student_name']);
        $sth->bindParam("student_sname", $input['student_sname']);
        $sth->bindParam("student_nickname", $input['student_nickname']);
        $sth->bindParam("student_sex", $input['student_sex']);
        $sth->bindParam("class_id", $input['class_id']);
        $sth->bindParam("par_user", $input['par_user']);
        
        $input['id'] = $this->db->lastInsertId();
        
        if ($sth->execute()){
            $err = "Success";
        }else{
            $err = "Fail";
        }
          
        return $this->response->withJson($err);
    }); 
       // registerstudent 
       $app->post('/registerstudent', function ($request, $response) {
        $input = $request->getParsedBody();
        $sql = "INSERT INTO student( st_id, st_title, st_name, st_lassname, st_class, pr_user) 
        VALUES (:st_id,:st_title,:st_name,:st_lassname,:st_class,:pr_user)";
         $sth = $this->db->prepare($sql);
        $sth->bindParam("st_id", $input['st_id']);
        $sth->bindParam("st_title", $input['st_title']);
        $sth->bindParam("st_name", $input['st_name']);
        $sth->bindParam("st_lassname", $input['st_lassname']);
        $sth->bindParam("st_class", $input['st_class']);
        $sth->bindParam("pr_user", $input['pr_user']);
        $input['id'] = $this->db->lastInsertId();
        if( $sth->execute()){
            $callback = array(
                status => 'Success',
                msg => 'Insert success'
            );
        }else{
            $callback = array(
                'status' => 404,
                'msg' => 'Insert Fail'
            );
        }
        return $this->response->withJson($callback);
    });
    // check register 
    
    $app->get('/checkuser/{teacher_user}', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM teacher2 WHERE teacher_user=:teacher_user");
        $sth->bindParam("teacher_user", $args['teacher_user']);
        // $sth->bindParam("tpassword", $args['tpassword']);
        $sth->execute();
        $teacher_user = $sth->fetch();   
        return $this->response->withJson($teacher_user);
    });
    $app->get('/parid/{par_user}', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM parent2 WHERE par_user=:par_user");
        $sth->bindParam("par_user", $args['par_user']);
        // $sth->bindParam("tpassword", $args['tpassword']);
        $sth->execute();
        $par_user = $sth->fetch();   
        return $this->response->withJson($par_user);
    });
    // check
    $app->get('/checkclassid/{class_name}&&{teacher_id}', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM classroom2 WHERE class_name=:class_name and teacher_id=:teacher_id");
        $sth->bindParam("class_name", $args['class_name']);
        $sth->bindParam("teacher_id", $args['teacher_id']);
        // $sth->bindParam("tpassword", $args['tpassword']);
        $sth->execute();
        $class_name = $sth->fetch();   
        return $this->response->withJson($class_name);
    });

    $app->get('/checkdatecheckname/{check_data}&&{teacher_id}', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM checkdate2 WHERE checkdate2.check_data=:check_data and checkdate2.teacher_id=:teacher_id");
        $sth->bindParam("check_data", $args['check_data']);
        $sth->bindParam("teacher_id", $args['teacher_id']);
        // $sth->bindParam("tpassword", $args['tpassword']);
        $sth->execute();
        $class_name = $sth->fetch();    
        return $this->response->withJson($class_name);
    });
// 
    $app->get('/checkaddsettingstudent2/[{ck_id}&&{ck_date}]', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM checkstudentname2 WHERE ck_id=:ck_id and ck_date=:ck_date");
        $sth->bindParam("ck_id", $args['ck_id']);
        $sth->bindParam("ck_date", $args['ck_date']);
        // $sth->bindParam("tpassword", $args['tpassword']);
        $sth->execute();
        $class_name = $sth->fetch();    
        return $this->response->withJson($class_name);
    });
    $app->get('/checkaddsettingstudent3/[{ck_date}]', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM `checkdate2`,`checkstudentname2`, WHERE checkstudentname2.ck_date=checkdate2.check_data and checkdate2.check_data =:ck_date ");
        $sth->bindParam("ck_date", $args['ck_date']);
        // $sth->bindParam("tpassword", $args['tpassword']);
        $sth->execute();
        $class_name = $sth->fetch();    
        return $this->response->withJson($class_name);
    });
    $app->get('/checkaddsettingstudent4/[{ck_date}&&{class_id}&&{ck_study}]', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM student2,checkstudentname2,classroom2,parent2 where student2.st_id = checkstudentname2.st_id and student2.par_user = parent2.par_user and checkstudentname2.ck_date=:ck_date and student2.class_id = classroom2.class_id   and student2.class_id=:class_id and checkstudentname2.ck_study=:ck_study  ");
        $sth->bindParam("ck_date", $args['ck_date']);
        $sth->bindParam("class_id", $args['class_id']);
        $sth->bindParam("ck_study", $args['ck_study']);
       $sth->execute();
       $todos = $sth->fetchAll();
       return $this->response->withJson($todos);
   });


    $app->get('/checkstudentname2/{ck_date}', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM checkstudentname2 WHERE ck_date=:ck_date");
        $sth->bindParam("ck_date", $args['ck_date']);
        // $sth->bindParam("tpassword", $args['tpassword']);
        $sth->execute();
        $class_name = $sth->fetch();   
        return $this->response->withJson($class_name);
    });
    // check registerstudent 
    
    $app->get('/checkstudent/{st_id}', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM student WHERE st_id=:st_id");
        $sth->bindParam("st_id", $args['st_id']);
        // $sth->bindParam("tpassword", $args['tpassword']);
        $sth->execute();
        $student = $sth->fetch();   
        return $this->response->withJson($student);
    });
    
    
    // login 
    
    $app->get('/login/[user={teacher_user}&&pass={teacher_password}]', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM teacher2 WHERE teacher_user=:teacher_user and teacher_password=:teacher_password");
        $sth->bindParam("teacher_user", $args['teacher_user']);
        $sth->bindParam("teacher_password", $args['teacher_password']);
        $sth->execute();
        $todos = $sth->fetch();   
        return $this->response->withJson($todos);
    });
    // teacher
    $app->get('/teacherall/[{teacher_user}&&{teacher_password}]', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM teacher2  WHERE teacher_user=:teacher_user and teacher_password=:teacher_password");
        $sth->bindParam("teacher_user", $args['teacher_user']);
        $sth->bindParam("teacher_password", $args['teacher_password']);
        $sth->execute();
        $todos = $sth->fetch();   
        return $this->response->withJson($todos);
    });
    // edit student checkdate2
    $app->any('/updatestudent/[{s_id}&&{st_title}&&{st_name}&&{st_lassname}&&{st_class}&&{pr_user}]', function ($request, $response, $args) {
        $sql="UPDATE student SET st_title=:st_title,st_name=:st_name,st_lassname=:st_lassname,st_class=:st_class,pr_user=:pr_user WHERE s_id=:s_id ";
        $sth = $this->db->prepare($sql); 
        
        $sth->bindParam("s_id ", $args['s_id ']);
        $sth->bindParam("st_title", $args['st_title']);
        $sth->bindParam("st_name", $args['st_name']);
        $sth->bindParam("st_lassname", $args['st_lassname']);
        $sth->bindParam("st_class", $args['st_class']);
        $sth->bindParam("pr_user", $args['pr_user']);
    
        
        if ($sth->execute()){
            $err = "Success";
        }else{
            $err = "Fail";
        }
          
        return $this->response->withJson($err);
    });
    // edit teacher 
    $app->any('/updateteacher/[{id}&&{user}&&{ttitle}&&{username}&&{lassname}&&{age}&&{useraddress}&&{phone}]', function ($request, $response, $args) {

        $sql="UPDATE teacher SET tuser=:user,title=:ttitle,tname=:username,tlassname=:lassname,tage=:age,taddress=:useraddress,tphone=:phone WHERE tid=:id";
        $sth = $this->db->prepare($sql);  

        $sth->bindParam("id", $args['id']);
        $sth->bindParam("user", $args['user']);
        $sth->bindParam("ttitle", $args['ttitle']);
        $sth->bindParam("username", $args['username']);
        $sth->bindParam("lassname", $args['lassname']);
        $sth->bindParam("age", $args['age']);
        $sth->bindParam("useraddress", $args['useraddress']);   
        $sth->bindParam("phone", $args['phone']);
        
        if ($sth->execute()){
            $err = "Success";
        }else{
            $err = "Fail";
        }
        //$edit = $sth->fetch();   
        return $this->response->withJson($err);
    });

    
 

 

    
 
    // DELETE student
    $app->any('/deletest/[{st_id}]', function ($request, $response, $args) {
         $sql="DELETE FROM student2 WHERE st_id=:st_id ";
         $sth = $this->db->prepare($sql); 
        $sth->bindParam("st_id", $args['st_id']);
        $sth->execute();
        if($sth->execute()){
            $dl = "Success";
        }else{
            $dl = "Fail";
        }

        return $this->response->withJson($dl);
    });
    // DELETE class
    $app->any('/deleteclass/[{class_id}]', function ($request, $response, $args) {
         $sql="DELETE FROM classroom2 WHERE class_id=:class_id ";
         $sth = $this->db->prepare($sql); 
        $sth->bindParam("class_id", $args['class_id']);
        $sth->execute();
        
        if($sth->execute()){
            $dl = "Success";
        }else{
            $dl = "Fail";
        }

        return $this->response->withJson($dl);
    });

    // DELETE student
    $app->any('/deletepar/[{par_id}]', function ($request, $response, $args) {
         $sql="DELETE FROM parent2 WHERE par_id=:par_id ";
         $sth = $this->db->prepare($sql); 
        $sth->bindParam("par_id", $args['par_id']);
        $sth->execute();
        
        if($sth->execute()){
            $dl = "Success";
        }else{
            $dl = "Fail";
        }

        return $this->response->withJson($dl);
    });
    // DELETE checknam
    $app->any('/deletecheckname/[{ck_id}]', function ($request, $response, $args) {
         $sql="DELETE FROM checkstudentname2 WHERE ck_id=:ck_id ";
         $sth = $this->db->prepare($sql); 
        $sth->bindParam("ck_id", $args['ck_id']);
        $sth->execute();
        
        if($sth->execute()){
            $dl = "Success";
        }else{
            $dl = "Fail";
        }

        return $this->response->withJson($dl);
    });


    $app->put('/testst/[{s_id}]',function ($request, $response, $args){
        $input = $request->getParsedBody();
        $sql = "UPDATE student SET st_name=:st_name WHERE s_id=:s_id";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("s_id", $args['s_id']);
        $sth->bindParam("st_name", $args['st_name']);
        
        $sth->execute();
        $input['s_id'] = $args['s_id'];
        return $this->response->withJson($input);
    });
    
$app->get('/search/[{query}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM parent2 WHERE par_name LIKE :query ORDER BY par_name");
   $query = "%".$args['query']."%";
   $sth->bindParam("query", $query);
   $sth->execute();
   $todos = $sth->fetchAll();
   return $this->response->withJson($todos);
});
    
$app->get('/searchclassroom/[{query}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM classroom2 WHERE class_name LIKE :query ORDER BY class_name");
   $query = "%".$args['query']."%";
   $sth->bindParam("query", $query);
   $sth->execute();
   $todos = $sth->fetchAll();
   return $this->response->withJson($todos);
});



// angular

$app->get('/studentId/{student_id}', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM student2 WHERE student2.st_id =:student_id");
    $sth->bindParam("student_id", $args['student_id']);
    $sth->execute();
    $todos = $sth->fetch();   
    return $this->response->withJson($todos);
});

$app->get('/checkparentuser/[{par_user}]', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM parent2 where par_user=:par_user ");
    $sth->bindParam("par_user", $args['par_user']);
   $sth->execute();
   $todos = $sth->fetchAll();
   return $this->response->withJson($todos);
});


