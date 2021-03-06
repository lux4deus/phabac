<?php
namespace Vokuro\Controllers;
use Ultimate\Acl\Models\News;
/**
 * Display the default index page.
 */
class IndexController extends ControllerBase
{
    /**
     * Default action. Set the public layout (layouts/public.volt)
     */
    public function indexAction()
    {
		$newsItem = News::findFirst([
			'conditions' => "access & ?0 AND owner = ?1",
			'bind' => [self::OWNER_CAN_READ, $this->user->id]
		]);
		
		if ($newsItem instanceof News) print("Новость найдена, ее текст: {$newsItem->text}");
		else print("Нет таких новостей");
		
		//if ($newsItem->access & self::OWNER_CAN_READ && $newsItem->owner == $this->user->id) print($newsItem->text);

        $this->view->setVar('logged_in', is_array($this->auth->getIdentity()));
        $this->view->setTemplateBefore('public');
    }
    
    public function testAction()
    {
		print("TEST works");
	}
    
    protected function calculateRight()
    {
		$policies = [];
		
		$policies[] = $this->watchdog->createPolicy("ACCEPT", "Access to the index action", "Access to the index action", [
			$this->watchdog->createRule("Check env string", "Check an str", [
				$this->watchdog->createCondition("$.environment._action", $this->watchdog->operator->equals, "index"),
			]),
		]);
		
		$policies[] = $this->watchdog->createPolicy("ACCEPT", "Access to the test action", "Access to the test action", [
			$this->watchdog->createRule("Check env day", "day", [
				$this->watchdog->createCondition("$.environment.day", $this->watchdog->operator->equals, "16"),
				$this->watchdog->createCondition("$.environment._action", $this->watchdog->operator->equals, "test"),
			]),
		]);
		
		return $policies;
	}
}
