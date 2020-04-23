<?php

/**
 * @copyright C UAB NFQ Technologies
 *
 * This Software is the property of NFQ Technologies
 * and is protected by copyright law – it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * Contact UAB NFQ Technologies:
 * E-mail: info@nfq.lt
 * http://www.nfq.lt
 *
 */

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Eimmar\IGDBBundle\DTO\Request\RequestBody;
use App\Form\Admin\IGDBRequestBodyType;
use App\Service\API\IGDBGameDataUpdater;
use Sonata\AdminBundle\Controller\CRUDController;
use Symfony\Component\Form\FormRenderer;

class IGDBController extends CRUDController
{
    private IGDBGameDataUpdater $igdbDataUpdater;

    /**
     * @param IGDBGameDataUpdater $igdbDataUpdater
     */
    public function __construct(IGDBGameDataUpdater $igdbDataUpdater)
    {
        $this->igdbDataUpdater = $igdbDataUpdater;
    }

    public function listAction()
    {
        $this->admin->checkAccess('create');
        $request = $this->getRequest();
        $igdbRequestBody = new RequestBody();
        $form = $this->createForm(IGDBRequestBodyType::class, $igdbRequestBody);

        try {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $results = $this->igdbDataUpdater->update($form->getData());
                $this->addFlash('sonata_flash_success', $this->trans(
                    'igdb.game.request_success',
                    [
                        '%created%' => $results['created'],
                        '%updated%' => $results['updated'],
                        '%total%' => $results['total'],
                    ]
                ));

                if ($request->request->get('btn_update_and_list')) {
                    return $this->redirectToRoute('sonata_admin_dashboard');
                }
            }
        } catch (\Exception $e) {
            $this->addFlash('sonata_flash_error', $this->trans('igdb.game.request_error'));
        }

        $twig = $this->get('twig');
        $formView = $form->createView();
        $twig->getRuntime(FormRenderer::class)->setTheme($formView, '@SonataDoctrineORMAdmin/Form/form_admin_fields.html.twig');

        return $this->renderWithExtraParams('admin/igdb/igdb_request.html.twig', [
            'action' => 'create',
            'form' => $formView,
            'object' => $igdbRequestBody,
            'objectId' => null,
        ]);
    }
}
