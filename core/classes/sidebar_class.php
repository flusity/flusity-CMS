<?php 
class Sidebar {

    private $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getSidebarItems()
    {
        $stmt = $this->db->query('SELECT * FROM sidebar ORDER BY id');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
}

}
