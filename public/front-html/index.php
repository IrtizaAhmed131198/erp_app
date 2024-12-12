<?php include 'include/header.php' ?>
<?php include 'include/menu.php' ?>

<section class="master-data-section">
    <div class="container bg-colored">
        <div class="row align-items-base justify-content-end master-data-filter invoice-listing-select-bar">
            <div class="col-xxl-3 col-xl-5 col-lg-5 col-md-12 col-12">
                <div class="parent-filter">
                    <select class="js-select2">
                        <option selected disabled>DEPARTMENT</option>
                        <option>COMPRESSION</option>
                        <option>EXTENSION</option>
                        <option>MULTI SLIDE</option>
                        <option>PRESS DEPT</option>
                        <option>PURCHASED</option>
                        <option>SLIDES</option>
                        <option>STOCK</option>
                        <option>TORSION</option>
                        <option>WIREFORM</option>
                    </select>
                    <!-- <div class="profile-details-save-btn">
                        <button class="btn custom-btn blue">
                            Filter
                        </button>
                    </div> -->
                </div>
            </div>
            <div class="col-xxl-3 col-xl-5 col-lg-5 col-md-12 col-12">
                <div class="parent-filter">
                    <select class="js-select2">
                        <option selected="">All</option>
                        <option value="1">Filter Option 1</option>
                        <option value="2">Filter Option 2</option>
                        <option value="3">Filter Option 3</option>
                    </select>
                    <!-- <div class="profile-details-save-btn">
                        <button class="btn custom-btn blue">
                            Filter
                        </button>
                    </div> -->
                </div>
            </div>
        </div>


        <div class="row align-items-center">
            <div class="col-lg-12">
                <div class="parent-table">
                    <table class="table table-hover table-bordered">
                        <thead>
                            <tr class="colored-table-row">
                                <th scope="col" class="highlighted toggle-header">
                                    <span class="icon">▼</span>
                                </th>
                                <th scope="col" class="toggleable toggle-header-department">DEPARTMENT <span
                                        class="icon">▼</span></th>
                                <th scope="col" class="toggleable toggle-header-work-center">WORK CENTER </th>
                                <th scope="col" class="toggleable toggle-header-planning">PLANNING (QUEUE) </th>
                                <th scope="col" class="toggleable">STATUS</th>
                                <th scope="col" class="toggleable">JOB #</th>
                                <th scope="col" class="toggleable">LOT #</th>
                                <th scope="col" class="toggleable">ID</th>
                                <th scope="col" class="toggleable">PART NO.</th>
                                <th scope="col" class="toggleable">CUSTOMER</th>
                                <th scope="col" class="toggleable">REV</th>
                                <th scope="col" class="toggleable">PROCESS</th>
                                <th scope="col" class="highlighted toggle-header-1">
                                    <span
                                        class="icon">▼
                                    </span>
                                </th>
                                <th scope="col" class="toggleable-1">REQ 1-6 WEEKS</th>
                                <th scope="col" class="toggleable-1">REQ 7-12 WEEKS</th>
                                <th scope="col" class="toggleable-1">SCHED'L TOTAL</th>
                                <th scope="col" class="toggleable-1">IN STOCK FINISHED</th>
                                <th scope="col" class="toggleable-1"> LIVE INVENTORY F</th>
                                <th scope="col" class="toggleable-1"> LIVE INVENTORY WIP</th>
                                <th scope="col" class="toggleable-1"> IN PROCESS OUT SIDE</th>
                                <th scope="col" class="toggleable-1"> ON ORDER RAW MAT'L</th>
                                <th scope="col" class="toggleable-1"> IN STOCK LIVE</th>
                                <th scope="col" class="toggleable-1"> WT/PC</th>
                                <th scope="col" class="toggleable-1"> MATERIAL (SORT)</th>
                                <th scope="col" class="toggleable-1"> Wt Req'd</th>
                                <th scope="col" class="toggleable-1"> SAFTY</th>
                                <th scope="col" class="toggleable-1"> Min Ship</th>
                                <th scope="col" class="toggleable-1"> Order Notes</th>
                                <th scope="col" class="toggleable-1"> Part Notes </th>
                                <th scope="col" class="highlighted toggle-header-2">
                                    <span
                                        class="icon">▼
                                    </span>
                                </th>
                                <th scope="col" class="toggleable-2">PAST DUE</th>
                                <th scope="col" class="toggleable-2">3-Jun</th>
                                <th scope="col" class="toggleable-2">10-Jun</th>
                                <th scope="col" class="toggleable-2">3-Jun</th>
                                <th scope="col" class="toggleable-2">10-Jun</th>
                                <th scope="col" class="toggleable-2">3-Jun</th>
                                <th scope="col" class="toggleable-2">10-Jun</th>
                                <th scope="col" class="toggleable-2">3-Jun</th>
                                <th scope="col" class="toggleable-2">10-Jun</th>
                                <th scope="col" class="toggleable-2">3-Jun</th>
                                <th scope="col" class="toggleable-2">10-Jun</th>
                                <th scope="col" class="toggleable-2">3-Jun</th>
                                <th scope="col" class="toggleable-2">10-Jun</th>
                                <th scope="col" class="toggleable-2">3-Jun</th>
                                <th scope="col" class="toggleable-2">10-Jun</th>
                                <th scope="col" class="toggleable-2">FUTURE RAW</th>
                                <th scope="col" class="toggleable-2">PRICE</th>
                                <th scope="col" class="toggleable-2">NOTES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td rowspan="1000" class="vertical-text highlighted">
                                    <div class="parent-hightlighted"><span>Details</span> <span>Details</span>
                                        <span>Details</span> <span>Details</span> <span>Details</span>
                                        <span>Details</span>
                                    </div>
                                </td>
                                <td class="toggleable toggle-department">COMPRESSION</td>
                                <td class="toggleable toggle-work-center">COM 1</td>
                                <td class="toggleable toggle-planning"><input type="text" name="" id=""></td>
                                <td class="toggleable"><input type="text" name="" id=""></td>
                                <td class="toggleable"><input type="text" name="" id=""></td>
                                <td class="toggleable"><input type="text" name="" id=""></td>
                                <td class="toggleable"></td>
                                <td class="toggleable">DRESDEN - RG</td>
                                <td class="toggleable">1000460</td>
                                <td class="toggleable">A00</td>
                                <td class="toggleable">C (Superior)</td>
                                <td rowspan="1000" class="vertical-text highlighted">
                                    <div class="parent-hightlighted"><span>INVENTORY</span> <span>INVENTORY</span>
                                        <span>INVENTORY</span> <span>INVENTORY</span> <span>INVENTORY</span>
                                        <span>INVENTORY</span>
                                    </div>
                                </td>
                                <td class="toggleable-1">0</td>
                                <td class="toggleable-1">30,000 </td>
                                <td class="toggleable-1">30,000 </td>
                                <td class="toggleable-1"><input value="30,000" type="text" name="" id=""></td>
                                <td class="toggleable-1"></td>
                                <td class="toggleable-1"><input type="text" name="" id=""></td>
                                <td class="toggleable-1"><input type="text" name="" id=""></td>
                                <td class="toggleable-1"><input type="text" name="" id=""></td>
                                <td class="toggleable-1"></td>
                                <td class="toggleable-1">8.000</td>
                                <td class="toggleable-1">MWB-0.045 / MWB-0.047</td>
                                <td class="toggleable-1">0</td>
                                <td class="toggleable-1"></td>
                                <td class="toggleable-1">25,000</td>
                                <td class="toggleable-1"></td>
                                <td class="toggleable-1">SUPERIOR .025EACH - MIN $200, CERT $20</td>
                                <td rowspan="1000" class="vertical-text highlighted">
                                    <div class="parent-hightlighted"><span>CALENDER</span> <span>CALENDER</span>
                                        <span>CALENDER</span> <span>CALENDER</span> <span>CALENDER</span>
                                        <span>CALENDER</span>
                                    </div>
                                </td>
                                <td class="toggleable-2"></td>
                                <td class="toggleable-2"></td>
                                <td class="toggleable-2"></td>
                                <td class="toggleable-2"></td>
                                <td class="toggleable-2"></td>
                                <td class="toggleable-2"></td>
                                <td class="toggleable-2"></td>
                                <td class="toggleable-2"></td>
                                <td class="toggleable-2"></td>
                                <td class="toggleable-2"></td>
                                <td class="toggleable-2">30,000</td>
                                <td class="toggleable-2"></td>
                                <td class="toggleable-2"></td>
                                <td class="toggleable-2"></td>
                                <td class="toggleable-2"></td>
                                <td class="toggleable-2"></td>
                                <td class="toggleable-2">$0.1404</td>
                                <td class="toggleable-2">SUPERIOR PLATINGS: .025EACH - MIN $200, CERT $20</td>
                            </tr>

                            <?php

                                for($i = 1; $i <= 100; $i++){
                                    echo '
                                <tr>
                                    <td class="toggleable toggle-department">COMPRESSION</td>
                                    <td class="toggleable toggle-work-center">COM 1</td>
                                    <td class="toggleable toggle-planning"><input type="text" name="" id=""></td>
                                    <td class="toggleable"><input type="text" name="" id=""></td>
                                    <td class="toggleable"><input type="text" name="" id=""></td>
                                    <td class="toggleable"><input type="text" name="" id=""></td>
                                    <td class="toggleable"></td>
                                    <td class="toggleable">DRESDEN - RG</td>
                                    <td class="toggleable">1000460</td>
                                    <td class="toggleable">A00</td>
                                    <td class="toggleable">C (Superior)</td>
                                    <!-- <td rowspan="1000" class="vertical-text highlighted"><span>INVENTORY</span> <span>INVENTORY</span> <span>INVENTORY</span></td> -->
                                    <td class="toggleable-1">0</td>
                                    <td class="toggleable-1">30,000 </td>
                                    <td class="toggleable-1">30,000 </td>
                                    <td class="toggleable-1"><input value="30,000" type="text" name="" id=""></td>
                                    <td class="toggleable-1"></td>
                                    <td class="toggleable-1"><input type="text" name="" id=""></td>
                                    <td class="toggleable-1"><input type="text" name="" id=""></td>
                                    <td class="toggleable-1"><input type="text" name="" id=""></td>
                                    <td class="toggleable-1"></td>
                                    <td class="toggleable-1">8.000</td>
                                    <td class="toggleable-1">MWB-0.045 / MWB-0.047</td>
                                    <td class="toggleable-1">0</td>
                                    <td class="toggleable-1"></td>
                                    <td class="toggleable-1">25,000</td>
                                    <td class="toggleable-1"></td>
                                    <td class="toggleable-1">SUPERIOR .025EACH - MIN $200, CERT $20</td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2">30,000</td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2"></td>
                                    <td class="toggleable-2">$0.1404</td>
                                    <td class="toggleable-2">SUPERIOR PLATINGS: .025EACH - MIN $200, CERT $20</td>
                                </tr>
                                ';

                                }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Add event listener to the column header
    document.querySelectorAll(".toggle-header").forEach(header => {
        header.addEventListener("click", function () {
            const columnClass = "toggleable"; // Class of the cells in the column
            const icon = this.querySelector(".icon"); // Dropdown icon

            // Toggle the collapsible state of the column
            const cells = document.querySelectorAll(`.${columnClass}`);
            cells.forEach(cell => {
                cell.classList.toggle("collapsible");
            });

            // Toggle the icon's rotation
            icon.classList.toggle("collapsed");
        });
    });
</script>

<script>
    // Add event listener to the column header
    document.querySelectorAll(".toggle-header-1").forEach(header => {
        header.addEventListener("click", function () {
            const columnClass = "toggleable-1"; // Class of the cells in the column
            const icon = this.querySelector(".icon"); // Dropdown icon

            // Toggle the collapsible state of the column
            const cells = document.querySelectorAll(`.${columnClass}`);
            cells.forEach(cell => {
                cell.classList.toggle("collapsible");
            });

            // Toggle the icon's rotation
            icon.classList.toggle("collapsed");
        });
    });
</script>

<script>
    // Add event listener to the column header
    document.querySelectorAll(".toggle-header-2").forEach(header => {
        header.addEventListener("click", function () {
            const columnClass = "toggleable-2"; // Class of the cells in the column
            const icon = this.querySelector(".icon"); // Dropdown icon

            // Toggle the collapsible state of the column
            const cells = document.querySelectorAll(`.${columnClass}`);
            cells.forEach(cell => {
                cell.classList.toggle("collapsible");
            });

            // Toggle the icon's rotation
            icon.classList.toggle("collapsed");
        });
    });

    // Add event listener to the column header
    document.querySelectorAll(".toggle-header-department").forEach(header => {
        header.addEventListener("click", function () {
            const columnClass = "toggle-department"; // Class of the cells in the column
            const icon = this.querySelector(".icon"); // Dropdown icon

            // Toggle the collapsible state of the column
            const cells = document.querySelectorAll(`.${columnClass}`);
            cells.forEach(cell => {
                cell.classList.toggle("active-td");
            });

            // Toggle the icon's rotation
            icon.classList.toggle("collapsed");

            // Add or remove the 'active' class to the header
            this.classList.toggle("active");
        });
    });


</script>

</body>

</html>

<?php include 'include/footer.php' ?>