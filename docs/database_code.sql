-- Tabla de estados
CREATE TABLE estados (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(50) NOT NULL
);

-- Tabla de tipos de licencia
CREATE TABLE tipos_licencias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  duracion INT NOT NULL, -- en días
  precio DECIMAL(10,2) NOT NULL
);

-- Tabla de empresas
CREATE TABLE empresas (
  nit VARCHAR(20) PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  direccion VARCHAR(150),
  telefono VARCHAR(20),
  correo VARCHAR(100)
);

-- Tabla de licencias
CREATE TABLE licencias (
  licencia VARCHAR(255) PRIMARY KEY,
  nit_empresa VARCHAR(20),
  fecha_compra DATE NOT NULL,
  fecha_fin DATE NOT NULL,
  id_estado INT,
  id_tipo_licencia INT NOT NULL,
  FOREIGN KEY (id_tipo_licencia) REFERENCES tipos_licencias(id),
  FOREIGN KEY (nit_empresa) REFERENCES empresas(nit),
  FOREIGN KEY (id_estado) REFERENCES estados(id)
);

-- Tabla de usuarios
CREATE TABLE usuarios (
  cedula VARCHAR(20) PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  correo VARCHAR(100) UNIQUE NOT NULL,
  nit_empresa VARCHAR(20),
  estado_id INT,
  contraseña VARCHAR(500) NOT NULL,
  FOREIGN KEY (estado_id) REFERENCES estados(id),
  FOREIGN KEY (nit_empresa) REFERENCES empresas(nit)
);

-- Tabla de admins
CREATE TABLE admin (
  cedula VARCHAR(20) PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  correo VARCHAR(100) UNIQUE NOT NULL,
  contraseña VARCHAR(255) NOT NULL
);

-- Tabla de recetas
CREATE TABLE recetas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  instrucciones TEXT
);

-- Tabla de ingredientes
CREATE TABLE ingredientes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL
);

-- Tabla de detalle de recetas
CREATE TABLE detalle_recetas (
  id INT AUTO_INCREMENT PRIMARY KEY,
  id_receta INT,
  id_ingrediente INT,
  cantidad DECIMAL(10,2) NOT NULL,
  unidad_medida VARCHAR(50) NOT NULL,
  FOREIGN KEY (id_receta) REFERENCES recetas(id) ON DELETE CASCADE,
  FOREIGN KEY (id_ingrediente) REFERENCES ingredientes(id)
);
