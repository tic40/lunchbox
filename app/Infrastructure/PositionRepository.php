<?php
namespace App\Infrastructure;

class PositionRepository
{
    public static function getPositions()
    {
        $positions = \App\positions::all();
        foreach ($positions as $position) {
            $positionEntities[] = static::setPositionEntity($position);
        }

        return $positionEntities;
    }

    public static function getPosition( $id ) {
        $position = \App\positions::find( $id );
        return static::setPositionEntity($position);
    }

    public static function storePosition($request) {
        $position = new \App\positions;
        $position->name = $request['name'];
        return $position->save();
    }

    public static function updatePosition($request, int $id) {
        $position = \App\positions::find($id);
        $position->name = $request['name'];
        return $position->save();
    }

    public static function deletePosition(int $id) {
        $position = \App\positions::find($id);
        return $position->delete();
    }

    private static function setPositionEntity(\App\positions $position)
    {
        $positionEntity = new \App\Entity\Position();
        $positionEntity->id = $position->id;
        $positionEntity->name = $position->name;
        return $positionEntity;
    }
}
