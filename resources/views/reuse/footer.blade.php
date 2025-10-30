<footer class="site-footer mt-auto">
  <div class="container-xxl py-3 d-flex flex-wrap justify-content-between align-items-center gap-2">
    <div class="d-flex flex-wrap align-items-center gap-2">
      <a
        class="link-neon neon-soft fw-bold"
        href="https://esleylealportfolio.vercel.app/"
        target="_blank"
        rel="noopener noreferrer"
        aria-label="Abrir portfólio de Esley Leal"
      >
        NOC
      </a>

    </div>

    <small class="mono">
     NOC N2
    </small>
  </div>
</footer>

<style>


   /* --- Footer --- */
.site-footer{
  border-top:1px solid var(--line);
  background: transparent; /* mantém o gradiente do body visível */
  color:#cbd5e1;
}
.site-footer small{ color:var(--muted) }

.link-neon{
  color:var(--neon-weak);
  text-decoration:none;
  border: 0;

}
.link-neon:hover{
  color:var(--neon);
  text-shadow:0 0 6px rgba(57,255,20,.35);
  border-color:rgba(57,255,20,.55);
}

/* (opcional) deixa o footer colado no fim da página */
body.compact{
  display:flex;
  flex-direction:column;
  min-height:100vh;
}
main{ flex:1 0 auto }
/* Final do Footer */

</style>
