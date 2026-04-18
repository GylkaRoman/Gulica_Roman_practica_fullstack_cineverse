namespace App\Repositories\Interfaces;

use App\DTO\MovieDTO;

interface MovieServiceInterface
{
    public function create(MovieDTO $dto);
}