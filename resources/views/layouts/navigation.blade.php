<div class="collapse navbar-collapse">
	<ul class="nav navbar-nav navbar-right">
		<li role="presentation" class="{{ isset($classes_resumen) ? $classes_resumen : '' }}">
			<a href="{{ route('home') }}">
				<span class="glyphicon glyphicon-home"></span>
				Resumen
			</a>
		</li>
		<li role="presentation" class="{{ isset($classes_categorias) ? $classes_categorias : '' }}">
			<a href="{{ route('categorias.index') }}">
				<span class="glyphicon glyphicon-list-alt"></span>
				Categorías
			</a>
		</li>
		<li role="presentation" class="{{ isset($classes_seguros) ? $classes_seguros : '' }}">
			<a href="{{ route('seguros.index') }}">
				<span class="glyphicon glyphicon-lock"></span>
				Seguros
			</a>
		</li>
		<li role="presentation" class="{{ isset($classes_atributos) ? $classes_atributos : '' }}">
			<a href="{{ route('atributos.index') }}">
				<span class="glyphicon glyphicon-th"></span>
				Atributos
			</a>
		</li>
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
				<span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span>
			</a>
			<ul class="dropdown-menu">
				<li role="presentation" class="disabled {{ isset($classes_polizas) ? $classes_polizas : '' }}">
					<a href="#">
						<span class="glyphicon glyphicon-ok"></span>
						Pólizas
					</a>
				</li>
				<li role="presentation" class="disabled {{ isset($classes_usuarios) ? $classes_usuarios : '' }}">
					<a href="#">
						<span class="glyphicon glyphicon-user"></span>
						Usuarios
					</a>
				</li>
				<li role="separator" class="divider"></li>
				<li role="presentation" class="disabled {{ isset($classes_aseguradoras) ? $classes_aseguradoras : '' }}">
					<a href="#">
						<span class="glyphicon glyphicon-road"></span>
						Aseguradoras
					</a>
				</li>
				<li role="presentation" class="disabled {{ isset($classes_formas_de_pago) ? $classes_formas_de_pago : '' }}">
					<a href="#">
						<span class="glyphicon glyphicon-credit-card"></span>
						Formas de Pago
					</a>
				</li>
				<li role="separator" class="divider"></li>
				<li role="presentation" class="disabled {{ isset($classes_archivo) ? $classes_archivo : '' }}">
					<a href="#">
						<span class="glyphicon glyphicon-picture"></span>
						Archivo
					</a>
				</li>
			</ul>
		</li>
	</ul>
</div>