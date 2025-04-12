<?php
require_once('admin_functions.php');
require_once '../../assets/php/send_code.php';

if(isset($_GET['verify_user'])){
    $user = getUserdata($_POST['user_id']);
    if(verifyEmail($user['email'])){
    
        $response['status']=true;

    }else{
        $response['status']=false;
    }

    echo json_encode($response);
}

if(isset($_GET['block_user'])){
   
    if(blockUserByAdmin($_POST['user_id'])){
    
        $response['status']=true;

    }else{
        $response['status']=false;
    }

    echo json_encode($response);
}



if(isset($_GET['unblock_user'])){
   
    if(unblockUserByAdmin($_POST['user_id'])){
    
        $response['status']=true;

    }else{
        $response['status']=false;
    }

    echo json_encode($response);
}


if(isset($_GET['search'])) {
    $keyword = $_POST['keyword'];
    $data = searchUser2($keyword);
    $users = "";
    $count = 1;
    if (count($data) > 0) {
        $response['status'] = true;
        foreach ($data as $suser) {
            $fbtn = '';
            $users .= '  <tr>
                          <td>#'. $count .'</td>
                          <td>
                            <div class="d-flex">
                              <div>
                                <img src="../assets/images/profile/'.$suser['profile_img'] .'" class="rounded-circle border border-2 shadow-sm mx-2" width="55px" height="55px" />
                              </div>
                              <div>
                                <h5>'.$suser['fname'] . ' ' . $suser['lname'] .' - <span class="text-muted">@'. $suser['username'] .'</span></h5>
                                <h6 class="text-muted">'. $suser['email'] .'</h6>


                              </div>
                            </div>
                          </td>

                          <td>';



                   if ($suser['ac_status'] == 0): $users.= '<button class="m-1 btn btn-warning btn-sm verify_user_btn" data-user-id="'. $suser['id'].'">Verify</button>';  endif; 


                   $users.= '<button style="display:'.($suser['ac_status'] == 1 ? '' : 'none' ).'" class="m-1 btn btn-danger btn-sm block_user_btn ub" data-user-id="'. $suser['id'] .'">Block</button>
                            <button style="display:'. ($suser['ac_status'] == 2 ? '' : 'none' ).'" class="m-1 btn btn-primary btn-sm unblock_user_btn" data-user-id="'. $suser['id'] .'">Unblock</button>



                          </td>

                        </tr>';
                        $count++;

        }
        $response['users'] = $users;
    } else {
        $response['status'] = false;
    }
    echo json_encode($response);
}