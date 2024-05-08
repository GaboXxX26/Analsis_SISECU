PGDMP  !    0                |            SIS    16.2    16.2     
           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                      false                       0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                      false                       0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                      false                       1262    27284    SIS    DATABASE     x   CREATE DATABASE "SIS" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'Spanish_Spain.1252';
    DROP DATABASE "SIS";
                postgres    false                        3079    27326 	   uuid-ossp 	   EXTENSION     ?   CREATE EXTENSION IF NOT EXISTS "uuid-ossp" WITH SCHEMA public;
    DROP EXTENSION "uuid-ossp";
                   false                       0    0    EXTENSION "uuid-ossp"    COMMENT     W   COMMENT ON EXTENSION "uuid-ossp" IS 'generate universally unique identifiers (UUIDs)';
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
    nombre_pro character varying(255),
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
       public         heap    postgres    false            �            1259    27309    user    TABLE     �  CREATE TABLE public."user" (
    id uuid NOT NULL,
    nombre character varying(255) NOT NULL,
    apellido character varying(255) NOT NULL,
    correo character varying(255) NOT NULL,
    telefono character varying(10),
    dni character varying(10),
    genero character varying(255),
    direccion character varying,
    fecha_nacimiento date,
    password character varying(50) NOT NULL,
    reset_password_token date,
    reset_password_sent_at bit(1),
    use_token character varying(10),
    rol_id uuid NOT NULL,
    id_centro uuid NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP
);
    DROP TABLE public."user";
       public         heap    postgres    false                      0    27292    centro 
   TABLE DATA           S   COPY public.centro (id_centro, id_pro, nombre_pro, estado, created_at) FROM stdin;
    public          postgres    false    217   �                 0    27304    permisos 
   TABLE DATA           D   COPY public.permisos (id, rol, estado_role, created_at) FROM stdin;
    public          postgres    false    218   �                 0    27285 	   provincia 
   TABLE DATA           G   COPY public.provincia (id_pro, nombre, estado, created_at) FROM stdin;
    public          postgres    false    216   �                 0    27309    user 
   TABLE DATA           �   COPY public."user" (id, nombre, apellido, correo, telefono, dni, genero, direccion, fecha_nacimiento, password, reset_password_token, reset_password_sent_at, use_token, rol_id, id_centro, created_at, updated_at) FROM stdin;
    public          postgres    false    219   �!       l           2606    27298    centro centro_pkey 
   CONSTRAINT     W   ALTER TABLE ONLY public.centro
    ADD CONSTRAINT centro_pkey PRIMARY KEY (id_centro);
 <   ALTER TABLE ONLY public.centro DROP CONSTRAINT centro_pkey;
       public            postgres    false    217            n           2606    27308    permisos permisos_pkey 
   CONSTRAINT     T   ALTER TABLE ONLY public.permisos
    ADD CONSTRAINT permisos_pkey PRIMARY KEY (id);
 @   ALTER TABLE ONLY public.permisos DROP CONSTRAINT permisos_pkey;
       public            postgres    false    218            j           2606    27291    provincia provincia_pkey 
   CONSTRAINT     Z   ALTER TABLE ONLY public.provincia
    ADD CONSTRAINT provincia_pkey PRIMARY KEY (id_pro);
 B   ALTER TABLE ONLY public.provincia DROP CONSTRAINT provincia_pkey;
       public            postgres    false    216            p           2606    27315    user user_pkey 
   CONSTRAINT     N   ALTER TABLE ONLY public."user"
    ADD CONSTRAINT user_pkey PRIMARY KEY (id);
 :   ALTER TABLE ONLY public."user" DROP CONSTRAINT user_pkey;
       public            postgres    false    219            t           2620    27345    user update_user_modtime    TRIGGER     �   CREATE TRIGGER update_user_modtime BEFORE UPDATE ON public."user" FOR EACH ROW EXECUTE FUNCTION public.update_updated_at_column();
 3   DROP TRIGGER update_user_modtime ON public."user";
       public          postgres    false    219    230            q           2606    27299    centro FK_centro.id_pro    FK CONSTRAINT        ALTER TABLE ONLY public.centro
    ADD CONSTRAINT "FK_centro.id_pro" FOREIGN KEY (id_pro) REFERENCES public.provincia(id_pro);
 C   ALTER TABLE ONLY public.centro DROP CONSTRAINT "FK_centro.id_pro";
       public          postgres    false    216    4714    217            r           2606    27337    user fk_rol_usu    FK CONSTRAINT     |   ALTER TABLE ONLY public."user"
    ADD CONSTRAINT fk_rol_usu FOREIGN KEY (rol_id) REFERENCES public.permisos(id) NOT VALID;
 ;   ALTER TABLE ONLY public."user" DROP CONSTRAINT fk_rol_usu;
       public          postgres    false    4718    218    219            s           2606    27346    user fk_usu_centro    FK CONSTRAINT     �   ALTER TABLE ONLY public."user"
    ADD CONSTRAINT fk_usu_centro FOREIGN KEY (id_centro) REFERENCES public.centro(id_centro) NOT VALID;
 >   ALTER TABLE ONLY public."user" DROP CONSTRAINT fk_usu_centro;
       public          postgres    false    219    217    4716               ?  x�uTI�\7]�O�0�(jZ:NvI�i�I�q�.�9N��#���*�
�K���z|O��5��� e�jdy��WKZZ��*��B§��9(��C���_L_.齿��$�,�;�vw�p�ҨŘ$�f� �e�j�%��D*eσ$7��ipԂ�'}���.�Y9W��u2@zSP8N�r����q�ڧg�d���3�sU��Z�H?>9O�����nsTP� ��f�i�i�,{���#����ؙI$@��LR{5�l�s���Yo ��]Na�E�b\%���qƮ��Z&��;�aB.d�N�s�^x���g��f�uHK0]>��V�V���wY��(���Y�\�S0���|ͮ������=c�+qD'��G2w�%m��.�R��+0l:^��;�WsM���������q�Xn���t��b{KshC�>!�x����(�	lK�^�^._���٪�x�Ac-�:b;�����S�'9�����I�#{��w٨I�R��o��7+�v.Tڵ`�Tq&�����\g��٧B�KC��:{֣xEz�����7@�H_U��&�<0���!�V��3�A|���X����Y�ա�.O������P�9���6#6��,�-qR�GD�
�i��	E��
SV��O��/o�Ln@��:�:�e�ă�M����X�����Y�ʛ�	�hTV,���^.�~�|���E+BC�;�14��Ep���0?��E}6�
	��hY�X�11E���냿�sK��%�)��Xɱ >�s%��1��<�°��]��8&^��Yy�'}x=��o�|�����_�G�d         �   x�m�1� @�N��2`�9D�.�R�HI���K�J~��%IT	
�D����]^���z�dz��f<z�#+�[���*��R��]e�$���Wy��Iۤrn��!�B�.���h1�$C����x3볯C�E�����b�� �7�           x�m�Mn�0���)t�)f���2H�l�h��f8$c�U�q��6=@O��u� q#������@�dv�C��`��&�2�\O�׳�2����{�:�q�#���0�̉l�dO����e��ߗ���O\G5�b[�
�!K�)����U�l��Ǭ�ќ�
\���Ё:/�[����r�g94�ھ��L;u��9��}�UkW4�?���);��Re�u���.�H.�䦧���d~���"��ƘD��S�L7.�جB1-9����0=o���d�3�!P1u�
Q��1i���^����f9ɨ��l���
&-��>��%�i~���eCΝ*�T��(pW59Y��Y�bcrn���~9�~c��43AOM#�h��T� ���~9��,�[B��Ͳ�MHJ � '�g�n@�G��f(O��yقG96k;}��Q����`u%�܀V��]k�@Lͣ�g�nX���q9��s�������㯁9lW3G������ݘg�솎l[�"g����i���l=         �  x���K�TA��տb�@.�TR�ܕ�,AA׳��^�֞iA��Σ]
B-*�9g��ll0���
��7����:������o�>���?�W���z<8o�4IrH�%jJɽ��������y{8Jw�=�g����n�=����+�ER`�'Z儩(&�'�4��6���un�����P�b�>^!�D��Eէ�/#��ٷu	,�NF+YRo�>�H*�,��T'������݇|�N��;��C�(�*Q�ɔ/0�|�%׼�����(���D�^x�F=��32�o�����f��yL�W�EIǿx�e�Z��(���C� �_�+�� [^Խ9�ww}�N�u�y������#a�����H���h�.!��Z��1�Pt�)'�IB��o�2�g�k�)g�w��n��	�>�     