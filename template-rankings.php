<?php
  /* Template Name: Rankings */
  get_header();
  ?>

  <section class="rankings-container">
    <div class="container">
      <h4 class="heading-with-cta"><span>SHARKS RANKINGS</span></h4>

      <table class="uk-table uk-table-striped">
        <thead>
          <tr>
            <th>Rank</th>
            <th>Player</th>
            <th>Monker</th>
            <th class="text-center">Total Wins</th>
            <th class="text-center">3-Man Wins</th>
            <th class="text-center">6-Man Wins</th>
            <th class="text-center">10-Man Wins</th>
            <th class="text-center">Total Games</th>
          </tr>
        </thead>
        <tbody id="stats-container">

        </tbody>
      </table>

      <div id="fetching-rankings">
        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
      </div>

      <div id="pagination-container"></div>
    </div>
  </section>

  <script>
    const baseUrl = 'https://billiards.luckytaya.com/api/shark/stat/';
    const currentDate = new Date();
    const currentYear = currentDate.getFullYear();
    const currentMonth = currentDate.getMonth() + 1; // Months are zero-indexed

    async function fetchStats(year, month) {
      const endpoint = `${baseUrl}${year}-${month.toString().padStart(2, '0')}`;
      const cacheKey = `stats-${year}-${month}`;

      // Check if data is already cached
      const cachedData = localStorage.getItem(cacheKey);

      if (cachedData) {
        return JSON.parse(cachedData);
      }

      const response = await fetch(endpoint);
      const data = await response.json();

      // Cache the fetched data
      localStorage.setItem(cacheKey, JSON.stringify(data));

      return data;
    }

    async function displayStatsInDescendingOrder() {
      const statsContainer = document.getElementById('stats-container');
      const paginationContainer = document.getElementById('pagination-container');
      const stats = [];

      for (let year = 2023; year <= currentYear; year++) {
        const endMonth = year === currentYear ? currentMonth : 12;

        for (let month = 1; month <= endMonth; month++) {
          const data = await fetchStats(year, month);
          stats.push(...data);
        }
      }

      stats.sort((a, b) => b["Total Win Games"] - a["Total Win Games"]);

      const itemsPerPage = 10;
      let currentPage = 1;
      const maxButtons = 5; // Maximum number of pagination buttons to display

      function updateStats() {
        statsContainer.innerHTML = '';

        const startIndex = (currentPage - 1) * itemsPerPage;
        const endIndex = startIndex + itemsPerPage;
        const currentStats = stats.slice(startIndex, endIndex);

        currentStats.forEach((stat, index) => {
          const statElement = document.createElement('tr');

          const rank = startIndex + index + 1; // Calculate the player's rank

          statElement.innerHTML = `<td>${rank}</td>
            <td>${stat.name}</td>
            <td>${stat.short_name}</td>
            <td class="text-center">${stat["Total Win Games"]}</td>
            <td class="text-center">${stat["3 Man Total Win Games"]}</td>
            <td class="text-center">${stat["6 Man Total Win Games"]}</td>
            <td class="text-center">${stat["10 Man Total Win Games"]}</td>
            <td class="text-center">${stat["Total Games"]}</td>`;

          statsContainer.appendChild(statElement);
        });
      }

      function updatePagination() {
        paginationContainer.innerHTML = '';

        const totalPages = Math.ceil(stats.length / itemsPerPage);
        const pagination = document.createElement('div');
        pagination.classList.add('pagination-list')

        const prevButton = document.createElement('button');
        prevButton.textContent = 'Previous';
        prevButton.classList.add('prev');
        prevButton.addEventListener('click', () => {
          if (currentPage > 1) {
            currentPage--;
            updateStats();
            updatePagination();
          }
        });

        const nextButton = document.createElement('button');
        nextButton.textContent = 'Next';
        nextButton.classList.add('next');
        nextButton.addEventListener('click', () => {
          if (currentPage < totalPages) {
            currentPage++;
            updateStats();
            updatePagination();
          }
        });

        if (currentPage === 1) {
          prevButton.disabled = true; // Disable the "Previous" button on the first page
        }

        if (currentPage === totalPages) {
          nextButton.disabled = true; // Disable the "Next" button on the last page
        }

        pagination.appendChild(prevButton);

        for (let i = Math.max(1, currentPage - Math.floor(maxButtons / 2)); i <= Math.min(totalPages, currentPage + Math.floor(maxButtons / 2)); i++) {
          const pageButton = document.createElement('button');
          pageButton.textContent = i;
          pageButton.classList.add('pagination-item');
          pageButton.addEventListener('click', () => {
            currentPage = i;
            updateStats();
            updatePagination();
          });

          // Add the "active" class to the currently selected page
          if (i === currentPage) {
            pageButton.classList.add('active');
          }

          pagination.appendChild(pageButton);
        }

        pagination.appendChild(nextButton);
        paginationContainer.appendChild(pagination);
      }

      updateStats();
      updatePagination();

      document.getElementById('fetching-rankings').remove();
    }

    displayStatsInDescendingOrder();
    
  </script>

  <?php get_template_part('includes/section', 'footer'); ?>

  <?php get_footer(); ?>