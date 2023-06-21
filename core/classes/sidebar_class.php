<?php 
class Sidebar {

    private $db, $prefix;

    public function __construct(PDO $db, $prefix)
    {
        $this->db = $db;
        $this->prefix = $prefix;
    }
    public function getAddonsItems()
    {
        $stmt = $this->db->query("SELECT * FROM " . $this->prefix['table_prefix'] . "_flussi_tjd_addons");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getSidebarItems()
{
    $stmt = $this->db->query("SELECT * FROM " . $this->prefix['table_prefix'] . "_flussi_sidebar ORDER BY IFNULL(order_number, 999999), id");
    $sidebarItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Get additional items from the addons table
    $addonItems = $this->getAddonsItems();

    foreach ($sidebarItems as &$item) {
        if (!isset($item['children'])) {
            $item['children'] = [];
        }

        foreach ($addonItems as $addon) {
            if ($addon['sidebar_id'] == $item['id'] && $addon['active'] == 1) {
                // Change the keys here based on what you want to display for addon items
                $addonSidebarItem = [
                    'id' => $addon['id'],
                    'parent_id' => $addon['sidebar_id'],
                    'icon' => $addon['icon'], // use actual icon from the table
                    'title' => $addon['name_addon'],
                    'url' => $addon['url'], // use actual url from the table
                ];
                

                $item['children'][] = $addonSidebarItem;
            }
        }
    }
    unset($item);

    return $sidebarItems;

    
}

    public function render()
{
    $sidebarItems = $this->getSidebarItems();

    $parentItems = array_filter($sidebarItems, function($item) {
        return $item['parent_id'] === null;
    });

    $childItems = array_filter($sidebarItems, function($item) {
        return $item['parent_id'] !== null;
    });

    $html = '<ul class="list-group list-group-flush">';
    foreach ($parentItems as $item) {
        $children = array_filter($childItems, function($child) use ($item) {
            return $child['parent_id'] === $item['id'];
        });

        $hasChildren = count($children) > 0;

        $html .= '<li class="list-group-item" ' . ($hasChildren ? 'id="settingsDropdown"' : '') . '>';
        $html .= '<a class="nav-link admin-link-item' . ($hasChildren ? '-point' : '') . '" href="'. getFullUrl($item['url']) .'" ' . ($hasChildren ? 'style="cursor: pointer;"' : '') . '>';
        $html .= '<i class="fas fa-' . $item['icon'] . '"></i>';
        $html .= '<span class="nav-text">'. t($item['title']) .'</span></a>';

        if ($hasChildren) {
            $html .= '<div id="settingsSubmenu" style="display: none;">';
            foreach ($children as $child) {
                $html .= '<a class="nav-link dropdown-item admin-link-item" href="'. getFullUrl($child['url']) .'">';
                $html .= '<i class="fas fa-' . $child['icon'] . '"></i>';
                $html .= '<span class="nav-text">'. t($child['title']) .'</span></a>';
            }
            $html .= '</div>';
        }

        $html .= '</li>';
    }
    $html .= '</ul>';

    return $html;

   // $sidebarItems = $this->getSidebarItems();
    
   // var_dump($sidebarItems);
   // exit;
}

}
