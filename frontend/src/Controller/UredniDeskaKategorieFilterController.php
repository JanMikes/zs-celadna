<?php

declare(strict_types=1);

namespace CeladnaZS\Web\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use CeladnaZS\Web\Services\Strapi\StrapiContent;
use CeladnaZS\Web\Value\Content\Data\KategorieUredniDesky;
use CeladnaZS\Web\Value\Content\Exception\InvalidKategorie;

final class UredniDeskaKategorieFilterController extends AbstractController
{
    public function __construct(
        readonly private StrapiContent $content
    ) {}


    #[Route('/uredni-deska/kategorie/{kategorie}', name: 'uredni_deska_kategorie_filter')]
    public function __invoke(string $kategorie, Request $request): Response
    {
        try {
            return $this->render('uredni_deska.html.twig', [
                'uredni_desky' => $this->content->getUredniDeskyData(category: $kategorie, shouldHideIfExpired: true),
                'kategorie_uredni_desky' => $this->content->getKategorieUredniDesky(),
                'active_kategorie' => $kategorie,
            ]);
        } catch (InvalidKategorie) {
            throw $this->createNotFoundException();
        }
    }
}
