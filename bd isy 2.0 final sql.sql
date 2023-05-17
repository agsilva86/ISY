CREATE TABLE cadastro (
  id_cad INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  condominio_id_cond INTEGER UNSIGNED NOT NULL,
  tiposdeusuario_id_tpusu INTEGER UNSIGNED NOT NULL,
  nome_cad VARCHAR(100) NOT NULL,
  cpf_cad VARCHAR(11) NOT NULL,
  unid_cad INT NOT NULL,
  bloco_cad CHAR(2) NULL,
  email_cad VARCHAR(100) NOT NULL,
  senha_cad VARCHAR(32) NOT NULL,
  foto_cad VARCHAR(255) NULL,
  doc_sind VARCHAR(255) NULL,
  PRIMARY KEY(id_cad),
  INDEX cadastro_FKIndex1(tiposdeusuario_id_tpusu),
  INDEX cadastro_FKIndex2(condominio_id_cond)
);

CREATE TABLE condominio (
  id_cond INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nome_cond VARCHAR(100) NOT NULL,
  rua_cond VARCHAR(50) NOT NULL,
  num_cond INT NOT NULL,
  bairro_cond VARCHAR(50) NOT NULL,
  cidade_cond VARCHAR(100) NOT NULL,
  cep_cond CHAR(8) NOT NULL,
  uf_cond CHAR(2) NOT NULL,
  PRIMARY KEY(id_cond)
);

CREATE TABLE documentos (
  id_doc INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  condominio_id_cond INTEGER UNSIGNED NOT NULL,
  cadastro_id_cad INTEGER UNSIGNED NOT NULL,
  desc_docs VARCHAR(100) NOT NULL,
  num_docs VARCHAR(100) NULL,
  tipo_docs VARCHAR(50) NOT NULL,
  datap_docs DATE NOT NULL,
  url_docs VARCHAR(255) NOT NULL,
  PRIMARY KEY(id_doc),
  INDEX documentos_FKIndex1(cadastro_id_cad),
  INDEX documentos_FKIndex2(condominio_id_cond)
);

CREATE TABLE pservico (
  id_ps INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  cadastro_id_cad INTEGER UNSIGNED NOT NULL,
  tipo_ps VARCHAR(50) NOT NULL,
  nome_ps VARCHAR(100) NOT NULL,
  aval_ps INT NOT NULL,
  coment_ps VARCHAR(255) NULL,
  PRIMARY KEY(id_ps),
  INDEX pservico_FKIndex1(cadastro_id_cad)
);

CREATE TABLE telefonecad (
  id_phonecad INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  cadastro_id_cad INTEGER UNSIGNED NOT NULL,
  ddd_phonecad CHAR(2) NOT NULL,
  num_phonecad VARCHAR(12) NOT NULL,
  tipo_phonecad VARCHAR(15) NOT NULL,
  PRIMARY KEY(id_phonecad),
  INDEX telefonecad_FKIndex1(cadastro_id_cad)
);

CREATE TABLE telefoneps (
  id_phoneps INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  pservico_id_ps INTEGER UNSIGNED NOT NULL,
  ddd_phoneps CHAR(2) NOT NULL,
  num_phoneps VARCHAR(12) NOT NULL,
  tipo_phoneps VARCHAR(15) NOT NULL,
  PRIMARY KEY(id_phoneps),
  INDEX Table_09_FKIndex1(pservico_id_ps)
);

CREATE TABLE tiposdeusuario (
  id_tpusu INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  nome_tpusu VARCHAR(20) NOT NULL,
  PRIMARY KEY(id_tpusu)
);


