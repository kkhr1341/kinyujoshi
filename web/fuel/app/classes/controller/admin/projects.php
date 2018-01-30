<?php

use \Model\Blogs;
use \Model\Projects;
use \Model\Courses;
use \Model\Sections;

class Controller_Admin_Projects extends Controller_Adminbase
{

    public function action_index()
    {
        $this->data['sections'] = Sections::lists();
        $this->data['all_projects'] = Projects::lists();
        $this->data['closed_projects'] = Projects::lists(0);
        $this->data['open_projects'] = Projects::lists(1);
        $this->template->contents = View::forge('admin/projects/index.smarty', $this->data);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・プロジェクト';
    }

    public function action_create()
    {
        $this->data['sections'] = Sections::lists();

        $this->template->contents = View::forge('admin/projects/create.smarty', $this->data);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・プロジェクト';
    }

    public function action_edit($code)
    {
        $this->data['projects'] = Projects::getByCode('projects', $code);
        $this->data['sections'] = Sections::lists();
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・プロジェクト';
        $this->template->contents = View::forge('admin/projects/edit.smarty', $this->data);
    }

    public function action_courses($code)
    {
        $this->data['projects'] = Projects::getByCode('projects', $code);
        $this->data['sections'] = Sections::lists();
        $this->data['all_courses'] = Courses::lists();
        $this->data['closed_courses'] = Courses::lists(0);
        $this->data['open_courses'] = Courses::lists(1);
        $this->template->contents = View::forge('admin/projects/courses/index.smarty', $this->data);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・プロジェクト';
    }

    public function action_courses_create($code)
    {
        $this->data['projects'] = Projects::getByCode('projects', $code);
        $this->template->contents = View::forge('admin/projects/courses/create.smarty', $this->data);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->description = 'マイページ・プロジェクト';
    }

    public function action_courses_edit($project_code, $code)
    {
        $this->data['projects'] = Projects::getByCode('projects', $project_code);
        $this->data['courses'] = Courses::getByCode('courses', $code);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->contents = View::forge('admin/projects/courses/edit.smarty', $this->data);
        $this->template->description = 'マイページ・プロジェクト';
    }


    public function action_blog($project_code)
    {
        $this->data['sections'] = Sections::lists();
        $this->data['all_blogs'] = Blogs::lists(null, null, null, null, $project_code);
        $this->data['closed_blogs'] = Blogs::lists(0, null, null, null, $project_code);
        $this->data['open_blogs'] = Blogs::lists(1, null, null, null, $project_code);
        $this->data['project'] = Projects::getByCode('projects', $project_code);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->contents = View::forge('admin/projects/blog/index.smarty', $this->data);
        $this->template->description = 'マイページ・プロジェクト';
    }

    public function action_blog_create($project_code)
    {
        $this->data['sections'] = Sections::lists();
        $this->data['project'] = Projects::getByCode('projects', $project_code);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->contents = View::forge('admin/projects/blog/create.smarty', $this->data);
        $this->template->description = 'マイページ・プロジェクト';
    }

    public function action_blog_edit($project_code, $code)
    {
        $this->data['sections'] = Sections::lists();
        $this->data['project'] = Projects::getByCode('projects', $project_code);
        $this->data['blogs'] = Blogs::getByCode('blogs', $code);
        $this->template->ogimg = 'https://kinyu-joshi.jp/images/kinyu-logo.png';
        $this->template->contents = View::forge('admin/projects/blog/edit.smarty', $this->data);
        $this->template->description = 'マイページ・プロジェクト';
    }
}
