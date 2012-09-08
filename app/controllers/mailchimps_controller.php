<?php
class MailchimpsController extends AppController
{
 var $name = 'Mailchimps';
var $components = array('MailchimpApi');
var $helpers = array('Mailchimp'); 

function mc() {
	
	echo 'jaswant';die;
	
    $lists = $this->MailchimpApi->lists();
    $this->set('lists', $lists); 
}

function mclist_view($id) {
    $lists = $this->MailchimpApi->listMembers($id);
    $this->set('id',$id);
    $this->set('lists', $lists); 
}

function mc_remove($user_email,$id) {
    $remove = $this->MailchimpApi->remove($user_email, $id);
    if($remove) {
        $this->Session->setFlash('Email successfully removed from your list.');
    } else {
        $this->Session->setFlash('Oops, something went wrong.  Email was not removed from the list.');
    }
       $this->redirect(array('action'=>'mclist_view', 'id'=> $id));
}


function mc_add($id) {
    if(!empty($this->data))
        {
        $first = $this->data['first'];
        $last = $this->data['last'];
        $email = $this->data['email'];
        $id = $this->data['id'];
        $add = $this->MailchimpApi->addMembers($id, $email, $first, $last);
        if($add) {
            $this->Session->setFlash('Successfully added user to your list.  They will not be reflected in your list until the user confirms their subscription.');
        } else {
            $this->Session->setFlash('Oops, something went wrong.  Email was not added to your user.');
        }
        $this->redirect(array('action'=>'mclist_view', 'id'=> $id));
    } else {
    $this->set('id',$id);
    }
}

}

?> 