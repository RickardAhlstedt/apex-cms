<?php

namespace App\Render;


use App\Models\Menu\Menu as MenuModel;
use Illuminate\Support\Facades\DB;

class Menu {

    public function __construct() {

    }

    public function buildMenu( $iParentId = 0, int $iDepth = 0, string $sGroup = 'guest') {
        $aResult = DB::select( "
            SELECT
                a.id, a.parent_id, a.name, a.href, a.class, a.behavior, a.prefix, a.suffix, a.sort, Deriv1.Count
            FROM
                `menus` a
            LEFT OUTER JOIN (
                SELECT
                    parent_id, COUNT(*) AS Count
                FROM
                    `menus`
                GROUP BY
                    parent_id
            ) Deriv1 ON a.id = Deriv1.parent_id
            WHERE
                a.parent_id = :parent_id
            AND
                a.group = :group
            ORDER BY
                a.sort
        ",
            [
                'parent_id' => $iParentId,
                'group' => $sGroup,
            ]
        );

        // Get the result
        if( !empty( $aResult ) ) {
            $sClass = '';
            if( $iDepth <= 0 ) {
                $sClass = 'navMain';
            } else if( $iDepth >= 1 ) {
                $sClass = 'navSub';
            }

            echo '<ul class="sidenav-menu">';

            // Build a recursive tree from the results
            foreach( $aResult as $aRow ) {
                echo '<li class="sidenav-item">';
                echo '<a href="' . $aRow->href . '" class="sidenav-link ' . $aRow->class . '">';
                echo $aRow->prefix . $aRow->name . $aRow->suffix;
                echo '</a>';

                // Recurse
                if( $aRow->Count > 0 ) {
                    $this->buildMenu( $aRow->id, $iDepth + 1, $sGroup );
                }

                echo '</li>';
            }
            echo '</ul>';
        }
    }
}
