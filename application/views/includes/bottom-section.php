
        <?php
            if($this->session->flashdata('msg')!==NULL || $this->session->flashdata('err_msg')!==NULL){
                $msg=$this->session->flashdata('msg');
                $err_msg=$this->session->flashdata('err_msg');
        ?>
        <div class="notify toastr-notify d-none" data-from="top" data-align="right" data-status="<?= !empty($msg)?'success':'danger'; ?>" data-title="<?= !empty($msg)?'Success':'Error'; ?>"><?= !empty($msg)?$msg:$err_msg; ?></div>
        <?php
            }
        ?>
        <div id="body-overlay" style="display: none;"></div>
        </div>
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="<?= file_url('assets/js/scripts.js'); ?>"></script>
        <script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
        <script src="https://threejs.org/examples/js/libs/stats.min.js"></script>
        <script>
          particlesJS("particles-js", {
            particles: {
              number: { value: 80, density: { enable: true, value_area: 800 } },
              color: { value: "#ffffff" },
              shape: { type: "circle" },
              opacity: { value: 0.5 },
              size: { value: 3, random: true },
              line_linked: {
                enable: true,
                distance: 150,
                color: "#ffffff",
                opacity: 0.4,
                width: 1,
              },
              move: {
                enable: true,
                speed: 4,
                direction: "none",
                random: false,
                straight: false,
                out_mode: "out",
              },
            },
            interactivity: {
              detect_on: "canvas",
              events: {
                onhover: { enable: true, mode: "repulse" },
                onclick: { enable: true, mode: "push" },
              },
              modes: {
                repulse: { distance: 150, duration: 0.4 },
                push: { particles_nb: 4 },
              },
            },
            retina_detect: true,
          });
        </script>
      <script>
         const sidebar = document.getElementById('sidebar');
         const toggleBtn = document.getElementById('mobile-menu-toggle');
         
         toggleBtn.addEventListener('click', () => {
             sidebar.classList.toggle('active'); // add/remove active class
         });
      </script>
   </body>
</html>
