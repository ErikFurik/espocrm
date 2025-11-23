<?php

namespace Espo\Modules\Autocrm\Controllers;

use Espo\Core\Api\Request;
use Espo\Core\Api\Response;
use Espo\Modules\Crm\Entities\Contact;
use Espo\ORM\EntityManager;

class FindContacts
{
	public function __construct(
		private EntityManager $entityManager
    ) {}

	public function actionIndex(Request $request, Response $response)
	{
		$email = $request->getQueryParam('email');

		if (!$email) {
			return ['list' => []];
		}

		$accountRepository = $this->entityManager->getRDBRepositoryByClass(Contact::class);

		$contacts = $accountRepository->where([
			'emailAddress' => $email
		])->find();

		$result = [];

		foreach ($contacts as $contact) {
			$result[] = [
				'firstName' => $contact->get('firstName'),
				'lastName'  => $contact->get('lastName')
			];
		}

		return ['list' => $result];
	}
}
