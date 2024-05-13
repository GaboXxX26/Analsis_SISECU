PGDMP  .    4    	    
        |            SIS    16.2    16.2                0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false                       0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false                       0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false                       1262    27284    SIS    DATABASE     x   CREATE DATABASE "SIS" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Spanish_Spain.1252';
    DROP DATABASE "SIS";
                postgres    false                        3079    27326 	   uuid-ossp 	   EXTENSION     ?   CREATE EXTENSION IF NOT EXISTS "uuid-ossp" WITH SCHEMA public;
    DROP EXTENSION "uuid-ossp";
                   false                       0    0    EXTENSION "uuid-ossp"    COMMENT     W   COMMENT ON EXTENSION "uuid-ossp" IS 'generate universally unique identifiers (UUIDs)';
                        false    2            �            1255    27344    update_updated_at_column()    FUNCTION     �   CREATE FUNCTION public.update_updated_at_column() RETURNS trigger
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
       public         heap    postgres    false            �            1259    28159 	   registros    TABLE     �   CREATE TABLE public.registros (
    id_registro uuid NOT NULL,
    id_centro uuid,
    conve_stra numeric,
    comp_insti numeric,
    opera_cam numeric,
    ausentimo numeric,
    mobile_locator numeric,
    dispoci numeric,
    com_estra numeric
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
       public         heap    postgres    false                      0    27292    centro 
   TABLE DATA           V   COPY public.centro (id_centro, id_pro, nombre_centro, estado, created_at) FROM stdin;
    public          postgres    false    217   �                 0    27304    permisos 
   TABLE DATA           D   COPY public.permisos (id, rol, estado_role, created_at) FROM stdin;
    public          postgres    false    218   :#       
          0    27285 	   provincia 
   TABLE DATA           G   COPY public.provincia (id_pro, nombre, estado, created_at) FROM stdin;
    public          postgres    false    216   �#                 0    28159 	   registros 
   TABLE DATA           �   COPY public.registros (id_registro, id_centro, conve_stra, comp_insti, opera_cam, ausentimo, mobile_locator, dispoci, com_estra) FROM stdin;
    public          postgres    false    220   #&                 0    27309    user 
   TABLE DATA           �   COPY public."user" (id, nombre, apellido, correo, telefono, dni, genero, direccion, fecha_nacimiento, password, reset_password_token, reset_password_sent_at, use_token, rol_id, id_centro, created_at, updated_at, estado) FROM stdin;
    public          postgres    false    219   )       p           2606    27298    centro centro_pkey 
   CONSTRAINT     W   ALTER TABLE ONLY public.centro
    ADD CONSTRAINT centro_pkey PRIMARY KEY (id_centro);
 <   ALTER TABLE ONLY public.centro DROP CONSTRAINT centro_pkey;
       public            postgres    false    217            r           2606    27308    permisos permisos_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.permisos
    ADD CONSTRAINT permisos_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.permisos DROP CONSTRAINT permisos_pkey;
       public            postgres    false    218            n           2606    27291    provincia provincia_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.provincia
    ADD CONSTRAINT provincia_pkey PRIMARY KEY (id_pro);
 B   ALTER TABLE ONLY public.provincia DROP CONSTRAINT provincia_pkey;
       public            postgres    false    216            v           2606    28163    registros registros_pkey 
   CONSTRAINT     _   ALTER TABLE ONLY public.registros
    ADD CONSTRAINT registros_pkey PRIMARY KEY (id_registro);
 B   ALTER TABLE ONLY public.registros DROP CONSTRAINT registros_pkey;
       public            postgres    false    220            t           2606    27315    user user_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public."user" DROP CONSTRAINT user_pkey;
       public            postgres    false    219            z           2620    27345    user update_user_modtime    TRIGGER     �   CREATE TRIGGER update_user_modtime BEFORE UPDATE ON public."user" FOR EACH ROW EXECUTE FUNCTION public.update_updated_at_column();
 3   DROP TRIGGER update_user_modtime ON public."user";
       public          postgres    false    219    231            w           2606    27299    centro FK_centro.id_pro    FK CONSTRAINT        ALTER TABLE ONLY public.centro
    ADD CONSTRAINT "FK_centro.id_pro" FOREIGN KEY (id_pro) REFERENCES public.provincia(id_pro);
 C   ALTER TABLE ONLY public.centro DROP CONSTRAINT "FK_centro.id_pro";
       public          postgres    false    217    4718    216            x           2606    27337    user fk_rol_usu    FK CONSTRAINT     |   ALTER TABLE ONLY public."user"
    ADD CONSTRAINT fk_rol_usu FOREIGN KEY (rol_id) REFERENCES public.permisos(id) NOT VALID;
 ;   ALTER TABLE ONLY public."user" DROP CONSTRAINT fk_rol_usu;
       public          postgres    false    219    4722    218            y           2606    27346    user fk_usu_centro    FK CONSTRAINT     �   ALTER TABLE ONLY public."user"
    ADD CONSTRAINT fk_usu_centro FOREIGN KEY (id_centro) REFERENCES public.centro(id_centro) NOT VALID;
 >   ALTER TABLE ONLY public."user" DROP CONSTRAINT fk_usu_centro;
       public          postgres    false    219    4720    217               r  x�uT9�#G�k^1H�����]� 	��u2�*�\�L��s�}�|LA�-�l�hVT��y�9�l/'�i�H�qvq{.$U��R�8�BSF'w�֛u><��ჽ\ގ�cf��b�ۉs�T�z����N��S�E-�}Le.-v�X�n�GI���}�������d�X��ԑҪ��6���Y%kRڰh���4V�d�H�U�O?<?�<,y>�Yu����h4t-iͺ���E�A����A��H\ZQ���b���*' ju��2� ���$X�}�U�{
%��bk��2����������9�,vJa�Rf�4���;Ґ�TK�Z�Js�ГD��i��!��L�O��	<�y8cy��E\�Ƃ�񲩙���V����	0t^���Wb	���7���8˄^��˄X�4;�#Me�R}Y��k��m@L6W������e�~=�/��e=�Vٚ�����#�"ӊR�.2�[��4�>	��x�Wx�����)�����"�`WΉR�l"�)˰�e�\F��N�\犈��l�k�d���r���' H��"Jn7�<0�)�%j�f��Pg�#�A|n�&��<�ޣ��C� ��i�{:���`�f����a�Y'.qBj�$CD�:
�i�	Ed�Sf������������	Tr-C�Q�
N��[S8�:(��,d�TzvZY�a	�hT�P/�������S���8c;0��4V����?sq��h,6*y���t��,6̥ܢz������9�5��%��'�Gwn�����;�+�xꭚ����sdA����^����3��iC`�0}�Z=uA�]���n8O����%��D���b�����G���,i�������b�N         �   x�m�1� @�N��2`�9D�.�R�HI���K�J~��%IT	
�D����]^���z�dz��f<z�#+�[���*��R��]e�$���Wy��Iۤrn��!�B�.���h1�$C����x3볯C�E�����b�� �7�      
   .  x�m�Mn1���)�,(��[mhТɲ���)lOa���� =E.Vz/`F�QOن�<T��u�s�1$H��8�y��^�g�_�����{3��ÑK%�	A�du�V�hk���vY���e�OTGU�bb]��!q�)�����&b�1JT��> 7t γ��(��_��̇Ƴ�;2�ʹ�h�s�G_Y�vA��s�to��#�T	hA,࣋5Z�sr�q;o'^������6)�,#�� ���V�1)9�����|=���QD���ZE ���Tc��ћ��\���ߴ9�X�Y�F2*��@V�V*���O\׉�����jD���ʭ&�6MQld�3�Vٯ'��0fjN2Y話b� ���jV�6��~=���o3�Di�j�E+$��� ǽg�n@̃Fh��"��0�6=��4A4�������oV@�j}rZi�@�h*Ybj=��`[>m����-�/�����_s�G3Gb��ק��]��[:�#�A��Y̘��Hn�s�҉�[;V�Aؒ�|�\u�'�v����         �  x�u�Q�1�����m�6��	��������(�"��>�iR�7�#�<)t_�����ɹ�-��vQ�S$���h�r�[�������O��f���";#h<��w���.�eW�Z�o�X�r�/���_�3���`����I�_<ß9�4�i�ţVF^�4P�]G���~蝡�i�H	p�:t����*K�k��0���S\nc�Ŧ>b|�_�l�]Z�	<�k5�=4�GE��݋���$�'�8I'v?�G=�EV���{�FH0��ȹ u����o��ѮN�~n��g���|�����E�Pr���Q��g3�-��x����<E��n��Y�ۡ�p.3^�A�=�fG�3N�q6���^0�(�4��JS΋{�a���C!_-[��f�XfڶG��\D���� [m�#V��I�.�m;�Fk ���1E�� ����\�1�-Zf��ӄNs�˾�拼�w"�*p?ǡ�1i����B����������������`�!���p�D��SY|��m��^;���i*i`H��x��O�xdI���]� zV�?��"WQ�X���>��G���~ڄ����ɘ�W��y�r�(�@�kP�O�m�4��+x��}V{�"��>��L��M>�_�M:rh������'��K�,��g��%���n���\�I=/*2ה��vp?c)���o5G�{�Z���A3W��.w��������/�p         �  x����n�6�����P�ɡ���Z�Ŷ��[�U8I���w��&^'��!J�5���Ff�+Hb91[��X�`��J�c>��ys�ݎ�~��a����n���@�	��#Q�����Ի�_��Z��vw4�R�Hց�sAr�y���On�I+�b�h��hs�����2��K�Lh�꼭�̕,e����ȉ! ��-�k�xŰ �s����Ӣ b��c�����+� ��Ί�:H�h���-� yԎ�l��i�1E��i��X!$/�%�s_����v�a@,̽���c̑+�H�`WmK�U�QL,�T��۰��l�!�)V�>ȕ�=����RNW��`�мy`�OsuR)����4�ق�z�8@e�~��j�����]��H�EB�����������v�w�ҧ3�U���3T�����ɢG2�\�60&W*�ӆ�5�Շ��%Rt�YȊJ�	$���擮�Ԡ�5&2�	#{lC��J8�4#������Ѭ|8�gEb�숞���~�ǉ���w��k���}�fX�ܡ�ΩP5��<�	
d�k`b�=��z!}�����4`� ;�]�T�
�!JΡ{��!z�m!�iB=
�4i-�����U>���.O�ܘv���C�c MM�$A��E�������B�Vy)5��
�2��J7���y�nC�3P��d�	E�e���%VdK�T�G(9;v-��%Ҍo�ʺ�ᡊ�CG�|�M����n��㩗#�X(���	�"P��L�/Ry�Uj#��4@�n�-@/��Dn����KҢ�9�K*aeX8I8�Oh}r�0����U��GB	���^��y7�>���1Z����Ky��ݷ	����y�\��*XMղ�C��B˥���~��-��g4��`u ГG�/WWW�3�     