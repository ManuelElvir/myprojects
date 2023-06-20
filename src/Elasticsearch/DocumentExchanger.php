<?php

namespace App\Elasticsearch;

use App\Model\Comment;
use App\Repository\CommentRepository;
use Elastica\Document;
use JoliCode\Elastically\Messenger\DocumentExchangerInterface;

class DocumentExchanger implements DocumentExchangerInterface
{
    private $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function fetchDocument(string $className, string $id): ?Document
    {
        if ($className === Comment::class) {
            $comment = $this->commentRepository->find($id);

            if ($comment) {
                return new Document($id, $comment->toModel());
            }
        }

        return null;
    }
}
