<?php namespace Modules\Pages\Http\Controllers;


use Kris\LaravelFormBuilder\FormBuilderTrait;
use Modules\Core\Events\MailerEvent;
use Modules\Core\Facades\MyApp;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Pages\Entities\Page;
use Modules\Pages\Http\Requests\ContactForm;
use Modules\Pages\Repositories\PageInterface;
use Redirect,Mail,Notification;

class PagesPublicController extends BasePublicController {

    use FormBuilderTrait;

	public function __construct(PageInterface $page)
	{
		parent::__construct($page);
	}

    /**
     * Page uri : lang/slug
     * @param Page $page
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
	public function uri(Page $page)
	{
		if (!$page) {
			abort('404');
		}

		if ($page->redirect) {
			$childUri = $page->children->first()->uri();

			return redirect($childUri);
		}

		// get submenu
		$children = $this->repository->getSubMenu($page->uri);

        $template = $this->_getTemplate($page);

		return view($template, compact('children', 'page'));
	}

    public function homepage()
    {
        $page = $this->repository->getFirstBy('is_home',1);

        $template = $this->_getTemplate($page);

        return view($template, compact('page'));
    }



    public function contactForm(ContactForm $request) {

        $data = array(
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'subject' => $request->get('subject'),
            'msg'=>$request->get('message')
        );
        Mail::send('pages::public.email._email', $data, function($send) use ( $request)
        {
            // $email = Settings::first()->contact_email;
            $email = config('myapp.contact_email','adedotunolawale@gmail.com') ;
            $send->from($request->get('email'), $request->get('name'));
            $send->to($email)->subject('Contact Form '.$request->get('email'));
        });
        return Redirect::to('contact-us')->withSuccess('Thank you for taking your time to fill our contact form, we will get back to you shortly');

    }

    /**
     * @param Page $page
     * @return string
     */
    private function _getTemplate(Page $page)
    {
        $templateDir = 'pages::public.';
        $template = $page->template ?: 'default';

        if (!view()->exists($templateDir . $template))
        {
            info('Template ' . $template . ' not found, switching to default template.');
            $template = 'default';
        }

        return $templateDir.$template;
    }

}