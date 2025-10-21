// Mochi State Management
const mochiState = {
    hp: 100,
    exp: 50,
    coins: 100,
    inventory: {}
};

async function fetchMochiStats() {
    try {
        const response = await fetch('/api/getMochiStats');
        const data = await response.json();
        mochiState.hp = data.hp;
        mochiState.exp = data.days; // Assuming 'days' is used as EXP
        mochiState.coins = data.coins;
        mochiState.inventory.int_food = data.int_food;
        mochiState.inventory.char_food = data.char_food;
        updateUI();
    } catch (error) {
        console.error('Failed to fetch Mochi stats:', error);
    }
}

function updateUI() {
    // Update HP bar
    const health = mochiState.hp;
    const maxHp = 100;
    const percent = health / maxHp * 100;
    document.querySelector('.hp-text').textContent = `HP: ${Math.round(percent)}%`;
    document.querySelectorAll('.healthbar_fill').forEach(fill => {
        fill.style.width = percent + "%";
    });
     if (percent <= 50) {
      document.documentElement.style.setProperty('--bar-fill', '#d6ed20');
      document.documentElement.style.setProperty('--bar-top',  '#d8ff48');
   }
   if (percent <= 25) {
      document.documentElement.style.setProperty('--bar-fill', '#ec290a');
      document.documentElement.style.setProperty('--bar-top',  '#ff3818');
   }


    // Update Days Alive
    const daysText = document.querySelector('.days-text');
    if (daysText) {
        daysText.textContent = `Days Alive: ${mochiState.exp}`;
    }

    // Update Coins
    document.querySelector('.coin-amount').textContent = mochiState.coins;

    // Update Inventory
    updateInventoryUI();
}

function updateInventoryUI() {
    const inventoryGrid = document.querySelector('.inventory-grid');
    inventoryGrid.innerHTML = ''; // Clear current inventory

    for (const itemKey in mochiState.inventory) {
        const count = mochiState.inventory[itemKey];
        if (count > 0) {
            const itemDetails = getItemDetails(itemKey);
            const inventoryItem = document.createElement('div');
            inventoryItem.classList.add('inventory-item');
            inventoryItem.innerHTML = `
                <span class="item-icon">${itemDetails.icon}</span>
                <span class="item-name">${itemDetails.name}</span>
                <span class="item-count">x${count}</span>
                <button class="eat-button" data-item="${itemKey}">Eat</button>
            `;
            inventoryGrid.appendChild(inventoryItem);
        }
    }
}

function getItemDetails(itemKey) {
    switch (itemKey) {
        case 'int_food':
            return { name: 'Int Soup', icon: '🥣' };
        case 'char_food':
            return { name: 'Char Cookies', icon: '🍪' };
        default:
            return { name: 'Unknown', icon: '❓' };
    }
}

async function buyItem(item, price) {
    console.log('Attempting to buy:', item, 'for', price, 'coins');
    console.log('Current coins:', mochiState.coins);

    try {
        const response = await fetch('/api/buyFood', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ food_type: item, price: price })
        });

        const responseData = await response.json();
        console.log('Server response:', responseData);

        if (response.ok) {
            console.log('Purchase successful! Refreshing stats...');
            await fetchMochiStats(); // Refresh data after purchase
        } else {
            alert(responseData.error || 'Not enough coins!');
        }
    } catch (error) {
        console.error('Failed to buy item:', error);
    }
}

async function eatItem(item) {
    try {
        const hp_amount = (item === 'int_food') ? 15 : 10; // Example: Int Soup gives more HP
        const response = await fetch('/api/eatFood', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ food_type: item, hp_amount: hp_amount })
        });
        if (response.ok) {
            fetchMochiStats(); // Refresh data after eating
        } else {
            const errorData = await response.json();
            alert(errorData.error || 'Failed to eat item.');
        }
    } catch (error) {
        console.error('Failed to eat item:', error);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    console.log('mochi-state.js loaded');

    // Initial fetch
    fetchMochiStats();

    // Set up periodic fetching
    setInterval(fetchMochiStats, 5000);

    // Event delegation for buy buttons (they're inside a modal that might not be visible at load)
    document.body.addEventListener('click', (e) => {
        console.log('Click detected on:', e.target, 'Classes:', e.target.classList);
        
        // Check if the clicked element is a buy button
        if (e.target.classList.contains('buy-button')) {
            console.log('✅ Buy button clicked!');
            e.preventDefault();
            e.stopPropagation();
            
            const storeItem = e.target.closest('.store-item');
            console.log('Store item found:', storeItem);

            if (!storeItem) {
                console.error('❌ Could not find parent .store-item');
                return;
            }

            const item = storeItem.dataset.item;
            const price = parseInt(storeItem.dataset.price);

            console.log('📦 Item:', item, 'Price:', price);
            console.log('💰 Current coins before purchase:', mochiState.coins);
            buyItem(item, price);
        }
    }, true); // Use capture phase to catch events before they bubble

    // Event listener for eat buttons (using event delegation)
    document.body.addEventListener('click', (e) => {
        if (e.target.classList.contains('eat-button')) {
            e.preventDefault();
            e.stopPropagation();
            const item = e.target.dataset.item;
            console.log('Eating item:', item);
            eatItem(item);
        }
    });
});

