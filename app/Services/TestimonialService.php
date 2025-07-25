<?php

namespace App\Services;

use App\Models\Testimonial;
use App\Traits\UploadImageTrait;

class TestimonialService
{
    use UploadImageTrait;

    public function getAll()
    {
        return Testimonial::latest()->paginate(10);
    }

    public function store(array $data): Testimonial
    {
        if (isset($data['image'])) {
            $data['image'] = $this->uploadImage($data['image'], 'testimonials');
        }

        return Testimonial::create($data);
    }

    public function update(array $data, Testimonial $testimonial): Testimonial
    {
        if (isset($data['image'])) {
            $data['image'] = $this->uploadImage($data['image'], 'testimonials');
            $this->deleteImage($testimonial->image);
        }

        $testimonial->update($data);
        return $testimonial;
    }

    public function delete(Testimonial $testimonial): void
    {
        $this->deleteImage($testimonial->image);
        $testimonial->delete();
    }
}