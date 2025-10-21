function toggleModal(modalId) {
    const storeModal = document.getElementById('store-modal');
    const inventoryModal = document.getElementById('inventory-modal');

    if (modalId === 'store') {
        if (!inventoryModal.classList.contains('hidden')) {
            inventoryModal.classList.add('hidden');
        }
        storeModal.classList.toggle('hidden');

        if (!storeModal.classList.contains('hidden')) {
            openTab('store-food');
        }

    } else if (modalId === 'inventory') {
        if (!storeModal.classList.contains('hidden')) {
            storeModal.classList.add('hidden');
        }
        inventoryModal.classList.toggle('hidden');
    }
}

function openTab(tabId) {
    const tabContents = document.querySelectorAll('.tab-content');
    tabContents.forEach(content => content.classList.remove('active'));

    const tabButtons = document.querySelectorAll('.store-tabs .tab-button');
    tabButtons.forEach(button => button.classList.remove('active'));

    const activeContent = document.getElementById(tabId);
    if (activeContent) {
        activeContent.classList.add('active');
    }

    const activeTabButton = document.querySelector(`.store-tabs button[onclick*="${tabId}"]`);
    if (activeTabButton) {
        activeTabButton.classList.add('active');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    openTab('store-food');
});
