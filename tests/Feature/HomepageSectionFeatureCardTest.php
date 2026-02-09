<?php

namespace Tests\Feature;

use App\Models\FeatureCard;
use App\Models\HomepageSection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomepageSectionFeatureCardTest extends TestCase
{
    use RefreshDatabase;

    public function test_homepage_section_can_have_feature_cards(): void
    {
        $section = HomepageSection::create([
            'key' => 'test_section',
            'title' => 'Test Section',
            'subtitle' => 'Test subtitle',
            'is_active' => true,
        ]);

        $card = FeatureCard::create([
            'homepage_section_id' => $section->id,
            'title' => 'Test Card',
            'description' => 'Test description',
            'icon' => '🎯',
            'color_from' => 'primary-50',
            'color_to' => 'white',
            'border_color' => 'primary-100',
            'text_color' => 'primary-800',
            'order' => 1,
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('feature_cards', [
            'id' => $card->id,
            'homepage_section_id' => $section->id,
        ]);

        $loadedSection = HomepageSection::with('featureCards')->find($section->id);
        $this->assertCount(1, $loadedSection->featureCards);
        $this->assertEquals($card->id, $loadedSection->featureCards->first()->id);
    }

    public function test_feature_card_belongs_to_homepage_section(): void
    {
        $section = HomepageSection::create([
            'key' => 'test_section',
            'title' => 'Test Section',
            'is_active' => true,
        ]);

        $card = FeatureCard::create([
            'homepage_section_id' => $section->id,
            'title' => 'Test Card',
            'description' => 'Test description',
            'icon' => '🎯',
            'color_from' => 'primary-50',
            'color_to' => 'white',
            'border_color' => 'primary-100',
            'text_color' => 'primary-800',
            'order' => 1,
            'is_active' => true,
        ]);

        $loadedCard = FeatureCard::with('homepageSection')->find($card->id);
        $this->assertNotNull($loadedCard->homepageSection);
        $this->assertEquals($section->id, $loadedCard->homepageSection->id);
        $this->assertEquals($section->title, $loadedCard->homepageSection->title);
    }

    public function test_feature_card_can_be_created_without_section(): void
    {
        $card = FeatureCard::create([
            'homepage_section_id' => null,
            'title' => 'Independent Card',
            'description' => 'This card is not associated with any section',
            'icon' => '📌',
            'color_from' => 'gold-50',
            'color_to' => 'white',
            'border_color' => 'gold-100',
            'text_color' => 'gold-800',
            'order' => 1,
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('feature_cards', [
            'id' => $card->id,
            'homepage_section_id' => null,
        ]);

        $loadedCard = FeatureCard::with('homepageSection')->find($card->id);
        $this->assertNull($loadedCard->homepageSection);
    }

    public function test_feature_card_can_have_featured_image(): void
    {
        $section = HomepageSection::create([
            'key' => 'test_section',
            'title' => 'Test Section',
            'is_active' => true,
        ]);

        $card = FeatureCard::create([
            'homepage_section_id' => $section->id,
            'title' => 'Card with Image',
            'description' => 'This card has a featured image',
            'featured_image' => 'feature-cards/test-image.jpg',
            'icon' => '🖼️',
            'color_from' => 'primary-50',
            'color_to' => 'white',
            'border_color' => 'primary-100',
            'text_color' => 'primary-800',
            'order' => 1,
            'is_active' => true,
        ]);

        $this->assertDatabaseHas('feature_cards', [
            'id' => $card->id,
            'featured_image' => 'feature-cards/test-image.jpg',
        ]);
    }

    public function test_deleting_section_cascades_to_cards(): void
    {
        $section = HomepageSection::create([
            'key' => 'test_section',
            'title' => 'Test Section',
            'is_active' => true,
        ]);

        $card = FeatureCard::create([
            'homepage_section_id' => $section->id,
            'title' => 'Test Card',
            'description' => 'Test description',
            'icon' => '🎯',
            'color_from' => 'primary-50',
            'color_to' => 'white',
            'border_color' => 'primary-100',
            'text_color' => 'primary-800',
            'order' => 1,
            'is_active' => true,
        ]);

        $section->delete();

        $this->assertDatabaseMissing('feature_cards', [
            'id' => $card->id,
        ]);
    }
}
