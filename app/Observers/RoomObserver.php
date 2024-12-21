<?php

namespace App\Observers;

use App\Models\Image;
use App\Models\Room;
use Illuminate\Support\Collection;

class RoomObserver
{
    private static Collection $images;

    public function __construct() {
        self::$images = collect([
            'https://images.wallpaperscraft.com/image/single/sofa_furniture_interior_design_70000_3840x2160.jpg',
            'https://cdn1.ozone.ru/s3/multimedia-w/6447922220.jpg',
            'https://i.pinimg.com/originals/a6/c9/17/a6c917bf98ee528435da81f5b767a869.jpg',
            'https://i.pinimg.com/736x/73/35/4f/73354fa91f5c9dde2ab8d2b17cb410bc.jpg',
            'https://st.hzcdn.com/simgs/pictures/bedrooms/contemporary-residence-boca-raton-florida-interiors-by-steven-g-img~b0c1626802b1b5d1_9-6223-1-56d34ae.jpg',
            'https://i.pinimg.com/originals/52/79/0d/52790df82e276c2d1ae71e23a3654883.jpg',
            'https://avatars.mds.yandex.net/i?id=44bd6eb8849973b7878294ef3db7a93e_l-4712318-images-thumbs&n=13',
            'https://i.pinimg.com/736x/d8/e4/03/d8e403498829303f3e3ab8483645cfa5.jpg',
            'https://www.davidmarquardtphotography.com/dmheat/wp-content/uploads/2016/06/Commercial-Interiors-002.jpg'
        ]);
    }
    /**
     * Handle the Room "created" event.
     */
    public function created(Room $room): void
    {
        $images = self::$images->random(3);
        foreach ($images as $image) {
            Image::create([
                'src' => $image,
                'room_id' => $room->Номер_комнаты,
            ]);
        }
    }

    /**
     * Handle the Room "updated" event.
     */
    public function updated(Room $room): void
    {
        //
    }

    /**
     * Handle the Room "deleted" event.
     */
    public function deleted(Room $room): void
    {
        //
    }

    /**
     * Handle the Room "restored" event.
     */
    public function restored(Room $room): void
    {
        //
    }

    /**
     * Handle the Room "force deleted" event.
     */
    public function forceDeleted(Room $room): void
    {
        //
    }
}
