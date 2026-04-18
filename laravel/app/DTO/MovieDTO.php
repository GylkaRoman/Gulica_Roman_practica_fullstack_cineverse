namespace App\DTO;

class MovieDTO {
    public function __construct(
        public string $title,
        public string $original_title,
        public string $description,
        public string $poster_url,
        public string $trailer_url,
        public string $genre,
        public int $duration,
        public string $age_rating,
        public string $director,
        public string $actors
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['title'],
            $data['original_title'],
            $data['description'],
            $data['poster_url'],
            $data['trailer_url'],
            $data['genre'],
            $data['duration'],
            $data['age_rating'],
            $data['director'],
            $data['actors'],
        );
    }
}