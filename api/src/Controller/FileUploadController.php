<?php

namespace App\Controller;

use App\Entity\Avatar;
use App\Repository\AvatarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FileUploadController extends AbstractController
{
    public function __construct(private AvatarRepository $avatarRepository)
    {
    }

    public function __invoke(Request $request): Response
    {
        $operator = $request->attributes->get('_api_normalization_context');
        if (!$operator){
            return $this->upload($request);
        }elseif ($operator["item_operation_name"] == 'post_image'){
            return $this->update($request);
        }else{
            throw new BadRequestException('Invalid operation');
        }
    }

    public function upload(Request $request): Response
    {
        try {
            $data = $request->request->all();
            $file = $request->files->get('file');
            if (!$file) {
                throw new \Exception('Invalid data');
            }
            $this->avatarRepository->create($data, $file);
            return new Response(null, Response::HTTP_CREATED);
        } catch (BadRequestException $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new Response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(Request $request): Response
    {
        try {
            $data = $request->attributes->get('data');
            if (!($data instanceof Avatar))
                throw new \Exception('Invalid data');

            $file = $request->files->get('file');
            if (!$file) {
                throw new \Exception('Invalid data');
            }
            $this->avatarRepository->update($data, $file);
            return new Response(null, Response::HTTP_OK);
        } catch (BadRequestException $e) {
            return new Response($e->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return new Response(null, Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

