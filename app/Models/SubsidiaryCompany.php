<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class SubsidiaryCompany extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'tagline',
        'short_description',
        'overview',
        'banner_image',
        'banner_heading',
        'banner_subtitle',
        'website_url',
        'website_button_text',
        'services',
        'highlights',
        'documents',
        'enquiry_email',
        'enquiry_enabled',
        'meta_title',
        'meta_description',
        'sort_order',
        'status',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'services' => 'array',
            'highlights' => 'array',
            'documents' => 'array',
            'enquiry_enabled' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function enquiries(): HasMany
    {
        return $this->hasMany(SubsidiaryEnquiry::class);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    protected static function booted(): void
    {
        static::creating(function (self $company) {
            if (blank($company->slug)) {
                $company->slug = static::uniqueSlug($company->name);
            }
        });
    }

    public static function uniqueSlug(
        string $name,
        ?int $ignoreId = null
    ): string {
        $base = Str::slug($name) ?: 'subsidiary';
        $slug = $base;
        $counter = 1;

        while (
            static::where('slug', $slug)
                ->when(
                    $ignoreId,
                    fn ($query) => $query->where('id', '!=', $ignoreId)
                )
                ->exists()
        ) {
            $slug = $base . '-' . $counter++;
        }

        return $slug;
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'subsidiary_company_id');
    }
}
