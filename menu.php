<div id="menu">
	<nav>
		<ul>
			<li>
				<a href="index.php">Home</a>
			</li>
			<?php if (isset($_SESSION["id"])) {
			?>
				<li>
					<label id="hov"><span>Patrimônio</span></label>
					<ol class=slide>
						<li><a href="consultarPatrimonio.php">Consultar Patrimônio</a></li>
						<?php
						if ($_SESSION["nivel"] == "adm") {
						?>
							<li><a href="frmCadBIOS.php">Cadastrar Modelo de Hardware</a></li>
						<?php
						}
						?>
						<li><a href="consultarBIOS.php">Consultar Modelo de Hardware</a></li>
					</ol>
				</li>
				<li>
					<label id="hov"><span>Docentes</span></label>
					<ol class=slide>
						<?php
						if ($_SESSION["nivel"] != "limit") {
						?>
							<a href="frmCadDocente.php">Cadastrar Docentes</a>
						<?php
						}
						?>
						<a href="consultarDocente.php">Consultar Docentes</a>
					</ol>
				</li>
			<?php
			}
			?>
			<li>
				<a href="sobre.php">Sobre</a>
			</li>
			<li>
				<?php
				if (!isset($_SESSION["id"])) {
				?>
					<span>Usuário desconectado</span>
				<?php
				} else {
				?>
					<label id="hov">
						<span>
							<?php
							echo "Logado como: " . $_SESSION["usuario"];
							?>
						</span>
					</label>
				<?php
				}
				?>
				<ol class=slide>
					<?php
					if (isset($_SESSION['nivel'])) {
						if ($_SESSION["nivel"] == "adm") {
					?>
							<li><a href="consultarUsuario.php">Listar Usuários</a></li>
							<li><a href="frmAddUsuario.php">Adicionar Usuário</a></li>
							<li><a href="frmTrocarSenha.php">Alterar senha</a></li>
							<li><a href="logout.php">Sair</a></li>
						<?php
						} else {
						?>
							<li><a href="frmTrocarSenha.php">Alterar senha</a></li>
							<li><a href="logout.php">Sair</a></li>
					<?php
						}
					}
					?>
				</ol>
			</li>
		</ul>
	</nav>
</div>