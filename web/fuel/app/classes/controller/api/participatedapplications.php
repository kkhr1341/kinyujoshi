<?php

use \Model\ParticipatedApplications;

class Controller_Api_Participatedapplications extends Controller_Apibase
{
    public function action_create()
    {
        try {
            $val = ParticipatedApplications::validate();
            if (!$val->run()) {
                $error_messages = $val->error_message();
                $message = reset($error_messages);
                return $this->error($message);
            }

            ParticipatedApplications::create($val->validated('application_code'));
            return $this->ok();
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
