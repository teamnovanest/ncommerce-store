<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // 
        $title = $this->faker->words(4, true);
        $colours = ['red', 'purple','green', 'move', 'orange'];
        $size = ["XS",'S', 'M','L', 'XL', 'XXL'];
        $status = [0,1];
        return [
            "category_id" => \App\Models\Category::all()->random()->id,
            "subcategory_id" =>  \App\Models\Subcategory::all()->random()->id,
            "brand_id" => \App\Models\Brand::all()->random()->id,
            "merchant_organization_id" =>  \App\Models\Merchant::all()->random()->id,
            "product_name" =>  ucwords($title),
            "product_code" => $this->faker->ean8(),
            "product_quantity" => $this->faker->randomNumber(4, false),
            "product_details" => $this->faker->paragraphs(3, true),
            "slug" => Str::slug($title),
            "sku" => $this->faker->ean13(),
            "product_color" => $this->faker->randomElement($colours),
            "product_size" => $this->faker->randomElement($size),
            "selling_price" => $this->faker->randomNumber(6, false),
            "image_one_public_id" => $this->faker->word(),
            "image_one_secure_url" => "https://loremflickr.com/320/240/random=1",
            "image_two_public_id" => $this->faker->word(),
            "image_two_secure_url" => "https://loremflickr.com/320/240/random=",
            "image_three_public_id" => $this->faker->word(),
            "image_three_secure_url" => "https://loremflickr.com/320/240/random=",
            "status" => $this->faker->randomElement($status),
        ];
    }
}
