PGDMP                      |            SIS    16.2    16.2                0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false                       0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false                       0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false                       1262    27284    SIS    DATABASE     x   CREATE DATABASE "SIS" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Spanish_Spain.1252';
    DROP DATABASE "SIS";
                postgres    false                        3079    27326 	   uuid-ossp 	   EXTENSION     ?   CREATE EXTENSION IF NOT EXISTS "uuid-ossp" WITH SCHEMA public;
    DROP EXTENSION "uuid-ossp";
                   false                       0    0    EXTENSION "uuid-ossp"    COMMENT     W   COMMENT ON EXTENSION "uuid-ossp" IS 'generate universally unique identifiers (UUIDs)';
                        false    2            �            1255    28182    actualizar_updated_at()    FUNCTION     �   CREATE FUNCTION public.actualizar_updated_at() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;
 .   DROP FUNCTION public.actualizar_updated_at();
       public          postgres    false            �            1255    28167    update_timestamp()    FUNCTION     �   CREATE FUNCTION public.update_timestamp() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = current_timestamp;
    RETURN NEW;
END;
$$;
 )   DROP FUNCTION public.update_timestamp();
       public          postgres    false            �            1255    27344    update_updated_at_column()    FUNCTION     �   CREATE FUNCTION public.update_updated_at_column() RETURNS trigger
    LANGUAGE plpgsql
    AS $$
BEGIN
    NEW.updated_at = CURRENT_TIMESTAMP;
    RETURN NEW;
END;
$$;
 1   DROP FUNCTION public.update_updated_at_column();
       public          postgres    false            �            1259    27292    centro    TABLE     �   CREATE TABLE public.centro (
    id_centro uuid NOT NULL,
    id_pro uuid,
    nombre_centro character varying(255),
    estado character varying(255),
    created_at date
);
    DROP TABLE public.centro;
       public         heap    postgres    false            �            1259    27304    permisos    TABLE     �   CREATE TABLE public.permisos (
    id uuid NOT NULL,
    rol character varying(20),
    estado_role character varying(10),
    created_at date
);
    DROP TABLE public.permisos;
       public         heap    postgres    false            �            1259    27285 	   provincia    TABLE     �   CREATE TABLE public.provincia (
    id_pro uuid NOT NULL,
    nombre character varying(255),
    estado character varying(255),
    created_at date
);
    DROP TABLE public.provincia;
       public         heap    postgres    false            �            1259    28169 	   registros    TABLE     >  CREATE TABLE public.registros (
    id_registro uuid NOT NULL,
    id_centro uuid,
    conve_stra numeric,
    comp_insti numeric,
    opera_cam numeric,
    ausentimo numeric,
    mobile_locator numeric,
    dispoci numeric,
    com_estra numeric,
    created_at timestamp with time zone DEFAULT CURRENT_TIMESTAMP
);
    DROP TABLE public.registros;
       public         heap    postgres    false            �            1259    27309    user    TABLE     �  CREATE TABLE public."user" (
    id uuid NOT NULL,
    nombre character varying(255) NOT NULL,
    apellido character varying(255) NOT NULL,
    correo character varying(255) NOT NULL,
    telefono character varying(10),
    dni character varying(10),
    genero character varying(10),
    direccion character varying,
    fecha_nacimiento date,
    password character varying(50) NOT NULL,
    reset_password_token date,
    reset_password_sent_at bit(1),
    use_token character varying(10),
    rol_id uuid NOT NULL,
    id_centro uuid NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    estado character varying(10)
);
    DROP TABLE public."user";
       public         heap    postgres    false                      0    27292    centro 
   TABLE DATA           V   COPY public.centro (id_centro, id_pro, nombre_centro, estado, created_at) FROM stdin;
    public          postgres    false    217   �%                 0    27304    permisos 
   TABLE DATA           D   COPY public.permisos (id, rol, estado_role, created_at) FROM stdin;
    public          postgres    false    218   K)                 0    27285 	   provincia 
   TABLE DATA           G   COPY public.provincia (id_pro, nombre, estado, created_at) FROM stdin;
    public          postgres    false    216   �)                 0    28169 	   registros 
   TABLE DATA           �   COPY public.registros (id_registro, id_centro, conve_stra, comp_insti, opera_cam, ausentimo, mobile_locator, dispoci, com_estra, created_at) FROM stdin;
    public          postgres    false    220   4,                 0    27309    user 
   TABLE DATA           �   COPY public."user" (id, nombre, apellido, correo, telefono, dni, genero, direccion, fecha_nacimiento, password, reset_password_token, reset_password_sent_at, use_token, rol_id, id_centro, created_at, updated_at, estado) FROM stdin;
    public          postgres    false    219   �/       s           2606    27298    centro centro_pkey 
   CONSTRAINT     W   ALTER TABLE ONLY public.centro
    ADD CONSTRAINT centro_pkey PRIMARY KEY (id_centro);
 <   ALTER TABLE ONLY public.centro DROP CONSTRAINT centro_pkey;
       public            postgres    false    217            u           2606    27308    permisos permisos_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.permisos
    ADD CONSTRAINT permisos_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.permisos DROP CONSTRAINT permisos_pkey;
       public            postgres    false    218            q           2606    27291    provincia provincia_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.provincia
    ADD CONSTRAINT provincia_pkey PRIMARY KEY (id_pro);
 B   ALTER TABLE ONLY public.provincia DROP CONSTRAINT provincia_pkey;
       public            postgres    false    216            y           2606    28175    registros resgitros_pkey 
   CONSTRAINT     _   ALTER TABLE ONLY public.registros
    ADD CONSTRAINT resgitros_pkey PRIMARY KEY (id_registro);
 B   ALTER TABLE ONLY public.registros DROP CONSTRAINT resgitros_pkey;
       public            postgres    false    220            w           2606    27315    user user_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public."user" DROP CONSTRAINT user_pkey;
       public            postgres    false    219                       2620    28183 '   registros trigger_actualizar_updated_at    TRIGGER     �   CREATE TRIGGER trigger_actualizar_updated_at BEFORE UPDATE ON public.registros FOR EACH ROW EXECUTE FUNCTION public.actualizar_updated_at();
 @   DROP TRIGGER trigger_actualizar_updated_at ON public.registros;
       public          postgres    false    233    220            ~           2620    27345    user update_user_modtime    TRIGGER     �   CREATE TRIGGER update_user_modtime BEFORE UPDATE ON public."user" FOR EACH ROW EXECUTE FUNCTION public.update_updated_at_column();
 3   DROP TRIGGER update_user_modtime ON public."user";
       public          postgres    false    219    231            z           2606    27299    centro FK_centro.id_pro    FK CONSTRAINT        ALTER TABLE ONLY public.centro
    ADD CONSTRAINT "FK_centro.id_pro" FOREIGN KEY (id_pro) REFERENCES public.provincia(id_pro);
 C   ALTER TABLE ONLY public.centro DROP CONSTRAINT "FK_centro.id_pro";
       public          postgres    false    4721    217    216            }           2606    28176    registros fk_centro_regis    FK CONSTRAINT     �   ALTER TABLE ONLY public.registros
    ADD CONSTRAINT fk_centro_regis FOREIGN KEY (id_centro) REFERENCES public.centro(id_centro) NOT VALID;
 C   ALTER TABLE ONLY public.registros DROP CONSTRAINT fk_centro_regis;
       public          postgres    false    220    217    4723            {           2606    27337    user fk_rol_usu    FK CONSTRAINT     |   ALTER TABLE ONLY public."user"
    ADD CONSTRAINT fk_rol_usu FOREIGN KEY (rol_id) REFERENCES public.permisos(id) NOT VALID;
 ;   ALTER TABLE ONLY public."user" DROP CONSTRAINT fk_rol_usu;
       public          postgres    false    218    4725    219            |           2606    27346    user fk_usu_centro    FK CONSTRAINT     �   ALTER TABLE ONLY public."user"
    ADD CONSTRAINT fk_usu_centro FOREIGN KEY (id_centro) REFERENCES public.centro(id_centro) NOT VALID;
 >   ALTER TABLE ONLY public."user" DROP CONSTRAINT fk_usu_centro;
       public          postgres    false    4723    217    219               r  x�uT9�#G�k^1H�����]� 	��u2�*�\�L��s�}�|LA�-�l�hVT��y�9�l/'�i�H�qvq{.$U��R�8�BSF'w�֛u><��ჽ\ގ�cf��b�ۉs�T�z����N��S�E-�}Le.-v�X�n�GI���}�������d�X��ԑҪ��6���Y%kRڰh���4V�d�H�U�O?<?�<,y>�Yu����h4t-iͺ���E�A����A��H\ZQ���b���*' ju��2� ���$X�}�U�{
%��bk��2����������9�,vJa�Rf�4���;Ґ�TK�Z�Js�ГD��i��!��L�O��	<�y8cy��E\�Ƃ�񲩙���V����	0t^���Wb	���7���8˄^��˄X�4;�#Me�R}Y��k��m@L6W������e�~=�/��e=�Vٚ�����#�"ӊR�.2�[��4�>	��x�Wx�����)�����"�`WΉR�l"�)˰�e�\F��N�\犈��l�k�d���r���' H��"Jn7�<0�)�%j�f��Pg�#�A|n�&��<�ޣ��C� ��i�{:���`�f����a�Y'.qBj�$CD�:
�i�	Ed�Sf������������	Tr-C�Q�
N��[S8�:(��,d�TzvZY�a	�hT�P/�������S���8c;0��4V����?sq��h,6*y���t��,6̥ܢz������9�5��%��'�Gwn�����;�+�xꭚ����sdA����^����3��iC`�0}�Z=uA�]���n8O����%��D���b�����G���,i�������b�N         �   x�m�1� @�N��2`�9D�.�R�HI���K�J~��%IT	
�D����]^���z�dz��f<z�#+�[���*��R��]e�$���Wy��Iۤrn��!�B�.���h1�$C����x3볯C�E�����b�� �7�         .  x�m�Mn1���)�,(��[mhТɲ���)lOa���� =E.Vz/`F�QOن�<T��u�s�1$H��8�y��^�g�_�����{3��ÑK%�	A�du�V�hk���vY���e�OTGU�bb]��!q�)�����&b�1JT��> 7t γ��(��_��̇Ƴ�;2�ʹ�h�s�G_Y�vA��s�to��#�T	hA,࣋5Z�sr�q;o'^������6)�,#�� ���V�1)9�����|=���QD���ZE ���Tc��ћ��\���ߴ9�X�Y�F2*��@V�V*���O\׉�����jD���ʭ&�6MQld�3�Vٯ'��0fjN2Y話b� ���jV�6��~=���o3�Di�j�E+$��� ǽg�n@̃Fh��"��0�6=��4A4�������oV@�j}rZi�@�h*Ybj=��`[>m����-�/�����_s�G3Gb��ק��]��[:�#�A��Y̘��Hn�s�҉�[;V�Aؒ�|�\u�'�v����         �  x��UIR�H<�W��,�̈~K_r��ƥn�ԀVPR"_�Ż�ͧ����e�%�/;�{�s�c!��s/j���ʠl3h�q���ɗ���j|��)V��,�8Q}�UO�շu�O�Z��`���H�i�r�k�	M��E��_q��i�pKS���U�_\�7z�v�[���X�`��2B����3r�ɫV;>������d�˙���D�w��������j������&�4���2�`Y�)�v�$�?�n�(�!�����4�ː�9�y�o_��y����ug�5[1&Pc��;+�����'�C�����ɱ��vYr���ן�w�x�_@$�Emm<�7|�V�6�����k/����d#ϱfY#x�/����/��W�>G�I"E֪P��~Y�PP`�Jט�x��@��j%>6�ݖ����� ��z.|5@#z�������|���ѹ,[�r�[�P�l0 �iS����Vs����۫�=���$h��o1�͎4�W��{*D|�޿.YI�T���?��R�9�H�-~� ^�?� ⁯9����Ew���蟡'v�ˤ'L�ظ�p Re�Vz}m���_O�۫� <�ߐ�6��;h�\�v��9)�b�V�l�e�ph,��YU���S?�S��~�_�ԏ�JnF��YՐ*h��cG]	-'�&\؃���}Ð�Q�Cs��g�����<ۧ�.�z��ws��Wl����u��L������������c�<������t5���6�q;���v�K�mN�������+�Ο�9�Sb�=�_�|�nZt��h�]X���h�I�+�h��v�/Fc����.�h���Rp]�ŗv�}�;��`d��;>�ҏ:��J�k�s�<�<���;���L���>�v���w�����������         �  x���K�\5�מ_1{�+��v��H�� �f�gh��3~=�0��	R��j�W_W}>�T���GV �rb�}�>r�.5���O�����������lv���^�z���Dt�G1I��on��v�?����Z�p��H)Y@K��� �`����[#i%X-wm��lN>�s-����=#X�Zo+6sE�Y*JI:d�u���x�� 8�pq�i�(����a������*�"��Xj�-�Rl��,F��0�h^�r���y��o�ټ���O"ڎ�3"��z����Y�C��b�Z�9Uߺő��X�����Pr��G���i�k�V��� �§�(-N����R�:
��Cy�Vm@���<�[��p�U"��˚?��FJ������k�����nW�TG�N,���с�U�֏�j=���Vnb�RN�eV��Su�J�.D⒘g,�
P�>R��V�� �F��F����pܨO~ͻͱ��~�p<��D�!����e�������]�5o��>�a�?"Qz�T��
[U
<�&(��5p���`:������3�-MU�\&ꔅG�R*~u��ND@'�8���\��"Xi�Z�-wݞ������<Erc���'�A�r�(A��E�<�9l�#�\��T���*�8�`���A݆:Fg���I*�&M��;�@��ŊlIB<3N���[_"����.vxWE���7H�����K����Ȓ�?If:h�
^kB�,�/�JMc�����@�n�s��Ki5!Р�Ѓ���#�K*ae�p�p����\���[�'��@Bo��7�`�̍��ç�*Ʃ<r�t!����4qZ��/��<�DY7��jY�T�ź�K\k����".��Ohh��ũ�4B�`�NV�rV�@���zpyT��{ �������:��Cb���8��~{��j)��qZF���[��W�)h\�R�-J�j�W�Q)�x�U��)�썣�!u��tVM�֋�*�P�_�d���a��P|������L�({     