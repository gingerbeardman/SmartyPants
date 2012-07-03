<?php if (!defined('APPLICATION')) exit();

//
// Copyright 2012 Matt Sephton
//
// Licensed under the Apache License, Version 2.0 (the "License");
// you may not use this file except in compliance with the License.
// You may obtain a copy of the License at
//
//    http://www.apache.org/licenses/LICENSE-2.0
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//

$PluginInfo['SmartyPants'] = array(
  'Description' => 'Adds SmartyPants Typographer support to discussions and comments.',
  'Version' => '1.01',
  'RequiredApplications' => NULL, 
  'RequiredTheme' => FALSE, 
  'RequiredPlugins' => FALSE,
  'HasLocale' => FALSE,
  'Author' => "Matt Sephton",
  'AuthorEmail' => 'matt@gingerbeardman.com',
  'AuthorUrl' => 'http://www.gingerbeardman.com'
);
require_once('vendors'.DS.'smartypants'.DS.'smartypants.php');

class SmartyPantsPlugin implements Gdn_IPlugin {
  
  // Standard rendering of comments.
  // See applications/vanilla/views/discussion/helper_functions.php

  // Look for BeforeCommentBody.
  public function DiscussionController_BeforeCommentBody_Handler($Sender) {
    $Comment = $Sender->CurrentComment;
    $Comment->Body = SmartyPants($Comment->Body);
  }

  // AJAX posting of dicussions
  public function DiscussionController_BeforeDiscussionRender_Handler(&$Sender) {
    $Sender->Discussion->Name = SmartyPants($Sender->Discussion->Name);
    $Sender->Discussion->Body = SmartyPants($Sender->Discussion->Body);
  }

  // AJAX posting of comments
  public function PostController_BeforeCommentBody_Handler($Sender) {
    $this->DiscussionController_BeforeCommentBody_Handler($Sender);
  }

  // AJAX preview of new discussions.
  public function PostController_BeforeDiscussionRender_Handler($Sender) {
    if ($Sender->View == 'preview') {
      $Sender->Comment->Body = SmartyPants($Sender->Comment->Body);
    }
  }

  // AJAX preview of new comments.
  public function PostController_BeforeCommentRender_Handler($Sender) {
    if ($Sender->View == 'preview') {
      $Sender->Comment->Body = SmartyPants($Sender->Comment->Body);
    }
  }

  public function Setup() {
  }
}
?>