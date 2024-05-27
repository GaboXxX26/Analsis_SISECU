PGDMP  	    #    	            |            SIS    16.2    16.2                0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
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
    id_pro uuid NOT NULL,
    nombre_centro character varying(255) NOT NULL,
    estado character varying(255) NOT NULL,
    created_at date NOT NULL
);
    DROP TABLE public.centro;
       public         heap    postgres    false            �            1259    27304    permisos    TABLE     �   CREATE TABLE public.permisos (
    id uuid NOT NULL,
    rol character varying(20) NOT NULL,
    estado_role character varying(10) NOT NULL,
    created_at date
);
    DROP TABLE public.permisos;
       public         heap    postgres    false            �            1259    27285 	   provincia    TABLE     �   CREATE TABLE public.provincia (
    id_pro uuid NOT NULL,
    nombre character varying(255) NOT NULL,
    estado character varying(255) NOT NULL,
    created_at date NOT NULL
);
    DROP TABLE public.provincia;
       public         heap    postgres    false            �            1259    28169 	   registros    TABLE     �  CREATE TABLE public.registros (
    id_registro uuid NOT NULL,
    id_centro uuid NOT NULL,
    conve_stra numeric NOT NULL,
    comp_insti numeric NOT NULL,
    opera_cam numeric NOT NULL,
    ausentimo numeric NOT NULL,
    mobile_locator numeric NOT NULL,
    dispoci numeric NOT NULL,
    com_estra numeric NOT NULL,
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
    password character varying(255) NOT NULL,
    reset_password_token date,
    reset_password_sent_at bit(1),
    use_token character varying(10),
    rol_id uuid NOT NULL,
    id_centro uuid NOT NULL,
    created_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    updated_at timestamp without time zone DEFAULT CURRENT_TIMESTAMP,
    estado character varying(10) NOT NULL
);
    DROP TABLE public."user";
       public         heap    postgres    false                      0    27292    centro 
   TABLE DATA           V   COPY public.centro (id_centro, id_pro, nombre_centro, estado, created_at) FROM stdin;
    public          postgres    false    217   l&                 0    27304    permisos 
   TABLE DATA           D   COPY public.permisos (id, rol, estado_role, created_at) FROM stdin;
    public          postgres    false    218   �)                 0    27285 	   provincia 
   TABLE DATA           G   COPY public.provincia (id_pro, nombre, estado, created_at) FROM stdin;
    public          postgres    false    216   �*                 0    28169 	   registros 
   TABLE DATA           �   COPY public.registros (id_registro, id_centro, conve_stra, comp_insti, opera_cam, ausentimo, mobile_locator, dispoci, com_estra, created_at) FROM stdin;
    public          postgres    false    220   �,                 0    27309    user 
   TABLE DATA           �   COPY public."user" (id, nombre, apellido, correo, telefono, dni, genero, direccion, fecha_nacimiento, password, reset_password_token, reset_password_sent_at, use_token, rol_id, id_centro, created_at, updated_at, estado) FROM stdin;
    public          postgres    false    219   �       s           2606    27298    centro centro_pkey 
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
       public          postgres    false    4723    217    219               p  x�uTI�d5]�N���ӲiX bZ��;�jUWJ5��q8C�.�K։�����~~�	�e� ?;HF�����O�jIs�V�tf�r*-��"���>tjz���������K*\��������F-�$��5�rّǪ�%'��L�;nB���f|z�qҷj����M��\���Y қ��q��1�jZ�$�}:{�m$��ͅ�T-�[������I�>߂�m�
�����4m;m�y���z�ê|eP�	Ш�Ij���v�ӏ�Oz���|r!���{�q8���c�T�,�{�<LH,ԩ�ҭ�2�(�'��f�uHKp;>LS�Q�]Z�;�Y���Ps��| �T��},_�+<�G}���Bug\��Bщz�{�.]vN�H�C%g��
�������U�����E���XRtA�C%tA,7Z��n�Om���94�@�>!�x������
lK�\�^._�ϧ�٪��\��Z�t�6m�ZO�)ѓ�ly�E`�$Ǒ���;oԤoɥ�__�oV��&%Snׂ-�S��^��]�LSv�)�����q�^�둽"���_L�� H���F�7�<0��V���Nj��f�<��U�L�)��3�:�~����߾>� j��`�W��T�a��.qR�fGD�
�i�̈́"J�� z|�����������V�Y����(צLprP�}{*Ṏ��"�l�(�h+��?��˻�.����iъ�lF�Ɗ��k�W��ә]�g���P����q�\��-Z�?^��[�e�ܡI�*�an���������CӭX�f��;l���#�`��t+�K4S�-Xq�X���j��/1�%ba��e��+/�),���Г>��G���7www�
䫄         �   x�m�1� @�N��2`�9D�.�R�HI���K�J~��%IT	
�D����]^���z�dz��f<z�#+�[���*��R��]e�$���Wy��Iۤrn��!�B�.���h1�$C����x3볯C�E�����b�� �7�         .  x�m�Mn1���)�,(��[mhТɲ���)lOa���� =E.Vz/`F�QOن�<T��u�s�1$H��8�y��^�g�_�����{3��ÑK%�	A�du�V�hk���vY���e�OTGU�bb]��!q�)�����&b�1JT��> 7t γ��(��_��̇Ƴ�;2�ʹ�h�s�G_Y�vA��s�to��#�T	hA,࣋5Z�sr�q;o'^������6)�,#�� ���V�1)9�����|=���QD���ZE ���Tc��ћ��\���ߴ9�X�Y�F2*��@V�V*���O\׉�����jD���ʭ&�6MQld�3�Vٯ'��0fjN2Y話b� ���jV�6��~=���o3�Di�j�E+$��� ǽg�n@̃Fh��"��0�6=��4A4�������oV@�j}rZi�@�h*Ybj=��`[>m����-�/�����_s�G3Gb��ק��]��[:�#�A��Y̘��Hn�s�҉�[;V�Aؒ�|�\u�'�v����            x��}Y�d9n�wi��I#�9w�q�Kx�$oF���Y�$Y�;+;�Cp�AFCfy�H�qA�S��'���ty�1��%���mt��(�)%ħ�[2c������9���_Q���U����_�ߒ��K\���O��O-M�}��
	�S��є�j�.���������q	�.M�Os}J̶6H����+�����W��)ru�F):�S��X=ۧ&����g�'7}-�In�Ǚ��2!��&E�Δ�ς������uv}=6��i�$��5��z��0.egŵ�����	烝+����7g����g�%����O�a}�|���L���O�->N>My� �ǔf�yʘ��s9�'���<�v9R������i~ǊF�c]�y?p�.>���)#����>E���?�j�z�ޞ^���/m�l��%������|I�d��h�;p���cb��h1�j�]��u�1
v+�_��#v�f�?���A�k�� ��_#�O]�oHxJ-�t�m�Ͷ6��d�����a�Tl}��{�aN?��~� 6�mb����I-�V��#ӴL�q�jc�W��?�+4��G"��A���	m������/��8����!7�RhV��n���.�?��4���i�8��+'����ħ�Z��~���Y��/O`�_ՙ]��gK��g˽�x�&���-��Ĝ���_�ݸ�Z;lIn��Ǜ�w������+�\{��
Z%�(�gk�{٠ީ<�<.w�s!��QV����r�_|�:]�g�BǶR�K��y5O�i��`w��c�kٖ�̖��5q��>����<�����)������y�է΅u����x��	#�f����B~{�5��gǡ[�a�wʐl�v�˿��}ug�ZݧM��[>K퓛!S��q��G���� OW��
�s���V'�BB9��>����b� 5��·�Ճ�Ý��Z�}������{{*�y�^)pԞ0����E��E�7��9��m�#O��c��ߠ`��H� do"����s��I΄e|-�1i�����nR�������Y]��2}l���������4Zu���1��s������/ӷ��$%@>�&�]��W��2�����W#�yT� �?6����j��6 �5�[>��w%�Zr}�8ah����.��{��Z_�V>߂�"��:�l�H}"�P�`�_��%�� iE��o�_�1��{�5�່�o�$P�N��}������V��^&���{��Z�n�2�d��X�D�:�?{� ��;,��wY�����n����� ��k��z�_�{�B�4�`�{������Uz�#ʼ���Ճ������K��|j�׃��[���Я�A����:44/�� =p�N�X���)6���o!�k�(��͂�"?���Y�L����>*��	6�(�8=��Hv�i"	�N1��և�/�t��&���9��j-��J�Pt�e_F~���<�ټ�Ԭ��z�T�.?��j���]��,�wc��,agp�p�Ъ�S�h��m#.�WQ�,���;�K{? �˾Pab	ۜt��~���Ye�[]ޛ؟����X�+�	f���E��Y>���4F���u�<�}�ހW�gUm�w��U���G�Y���V��C�Y��P��4 	��#��G ٨�ݟ�������b��c�L"�A�G�w�㥥�x��t�
R���b�A�mB����W�m$韽������Ht@@�#�c��=��Y=���RF�k�!8Z�أ�^��鮢�Y���=!:D6 Z�7�J��\��q �p�>X{���Nv�Yj¶��ـS�O���"D\ �y\��ţ��L�3�{��T�y�B�x3=�Vk��h�����a3K�`3;ȦY~/ |@D�c�vUG�t�ț�dU`~B:~���młGS�U�?������1���.�6B�/�������E����q����v�o#@�����v���Ϗ؃�{��cl�n�0�+���8����Z'�+�@
�� ����Ϯ}Κ6�����G��j�P�٠�>:D~��Ҡ�R�%��XNe) v�F�;-�8^(@�cK*A���@�� ���q���x�|#��ƻ��of8���Ǻ�/!���Y��ۘb4�{���V"o��a���F����S ��� h�)���e]�f5�:��i(�5��[��.A6G�8� �1�3�2"�T|��ȸu���~�m�ؕ�΃83�Щgbwm�t����X]�a�� )`Wqञ�jb� ^\�8�j������� a����{��L`�֣gXû���GwЇ�E��	��_�=Z-�[��x�?����R�7]�8I@?���_��AC���\}�s�i���=C���;�@���-��X�Y���ѡ��߆�Wl��;@{k�����ǰ��4�_���',���)X��п��/�5P�,��}�P:�BpQlB�}��d���0��-����~����GO�f��|�rs�8�Zȷ������ag����S�L�5(���/qH ���a�k�d�m�]15��:�a��n����\LL�����#��k�X��e�w��H���l	���և�] �-ç�����0���<P��,��r��������E�I���{��j<��M��#�3���Y�h<�J�f��֠�o>������b�rd�5�t0�_0�?�ևlnA�ku���d����6�8Z������}�P�k���|2����� �n�y��!�����n!�ku=�/D/я�#�`=�x��=б�y��\=�o�����F�me��w��*"T���V��Jzy��#"�w�Ne����qJ3�"��	�7�k�»"�N%����q�KѦ����=���̾�R�i���Ӈ�����_b������;��@�� �9n:�����#�"��3�#���)��+����7n]� ��q�� ĂS�|pf�C1�r��cyq����fL�i�*�|�
fjk ���!���c}���Ry��:�ߡ4�@�{�H⼃��[��nӻ���%�;`f������%���K���~:	�C��@�bLT�4��p]@}CМ�-�������Az���>�I	'��9�{����~ꝶ4�" �|k��y�� �4 ��%��Xtw�_03K��V�!�=����We(����X=��׮�Tڲ'Xv(�?����x�t�K���~��^bABM��@��J���NS�m7���X=���an/�^`�.v��~��ؙ��������S4������<u |\!��U�@�������X,`*\ �����:��������]ħ'�Z�� �"�L��<M��q�m����kش/�ju��~��W"�G )3������~���-����}G�+A�+�!L���l�c&ZM�1]B�?�x���U�3��G�^f�uC�1U�������;��ù _���O.��8���p�	�1߃����9�]�c�{�Vj׀
x���[1������M�m$�sZ^�(�"��^�*�LnA�k}`�������a�95Z�:`�@�E� �% (Xé�ǮK�C�>����1A���/	p;�h�����W��)g�Ю�)�����|2�S����l������8�8�Ox�nA���a;�3»��=�|�����̠! ����~ּ��0�x���ؑx�7� V�F�ttw2��W��d�E�<G�;ߛ�W
�U<l�EqE�����;���DD]E,!N0Yx�|v֖]�����s�}����h��t+_y���Tܔ���@�Ns�=D��<�ʚ��s�2ZW�����m��U�Tp���0�d]8|`�ϵণ�ெ���V��0���� ��W�����;��抣����������mv_� ��K�a᥺���ň�~QK����	y�PF|F뵍��r�?�׸�*�ܥc_�2�g��g    �Ie����\��}���^ �@�[�e`$�A�xl+v��R����?�r�N7�40���g��q!����t	�?��.�W"��V��Ӹ�qLwhPh���Z�ߧ��T�&#��B�B����+τ��FMw��c}A�sȇ� �֯��Ip���غ�n����j���a�mS��\	��	)����;���>���6(B�Ak����r�WX�7�#���\�[]������	�	���M~", ����=���Y��aؑ��Y��	�c��5\'�L7��su��Zf
���;Y�X������v�ӭ¾O�n�ڂ�3�����@��PM�@�X�z�����zn\S�;�"���W����q���/`���E�xw�7����/%�>E(`�º�B?��l篣���^^��s�H�X����R���~N;�0�>��a����R�y@D�zm
:�J���\?��yV̧��D:�)�
h���;v��� �.���5��nVu��c��!O'��S��̣�4�b�Z�9��t�hK��XY�@n���2�m�_����d��d��R~�1�9��̞B��:�/	�?	�Ȩ]�\6� ��tV�z� ��ؿ�_���K
���u��_�#�o�P�M{��z6a�O|��ݪ�L��g�� �N�b�z�\������%u�+�1,i���	 Ę2z���kuw�5���� E	��Oe� ���#�+�}��C�����u�1���	���VB��񀏗y���p�;ѩ"���⇕�=Ц���X�"��!�q�� ,+_�ך�L8��?G_5�?�����m�_������[����qU�;&�̷���>��s�~��'&��_�}[d�Ȩ: �$/�_�K�/� x�K�{�ѳ�H�X��p����K���� �م�Q�#A��u���!��Uk���"E�k(��ִ|G���/,�����o/��D��=`�D
L��;l�:�ٿco"�g"�%��Op����h t}d���v� �=�����	�F�?ݝ
�N�.>��ȻY�A ̀ȕ=��迣o{�76pd����w�ѳ� +.�R
�D3zXL՞�cd��!�NB	>��2�H��>(�q�Klm�~Y��G��1�#@��::3їE�R���{��A�|��Ԛw_f,	� G �<;�
Pp����{�,5�:�ڙ�L|ۂ�L�y߇t����TǨ��P�@F�D�ܡ��+xw�߁t 209�\�������i#3?n��h���������Z� �������44=bG`�� p~�~4�/�ଏ��-��"	�CN\	
��]y�.}��6�o����Od���P̓�x�[��1�▊K�;z�#�_	 �N�&���{ �rd��ࣰ� 4��#�$�&���[�`�q�!&�"�E�u�B-H����dH�/�N���Z�v�*�pI�b�ǻ*�����=�\��E@�<`x-�����!��	K=�̗��Ѓ��L�5[�a<�X�/��Kg�t��у	��i��3<�&@H(l@�y[g����.уO	ҩK
�4fD��'�Xa�06����&=��!��P$U�A�[�J�;am&����K�7���Gk3I���m-�XH�1��T�5~�.A��-�T*��2_�ل���0�A��:"���k����� 9�
ۢ/�QvFq\-1o�� �J�x��>$o84�4�ـ�L,�^��>}"��ւK}�d�w��)@����Z�8)O^�:�ɂ=�jHӪ$s�"|�n?�x ~qF��YmI�wL{�����_)���iWI���_���)�����&,/����"|�`�Κ���x�gG@װ�)<,����2�Q�O	�����������t}���#)�Ij2آ��������>����o'�'�}q�D���s3�ᢲLK��
u�_��
^���L�����1�[�c��&C����&�e��W��M=wwd$6f���Z����������o�7����9���Og�\N�A�TV�W��\�o��u��F�p�Ѓբ(2o�>��k�͗�_�w	��M�@�5T���-8�	� ����7 ���b�L�-�"\�]��G�����B��
 }��$�=B�J�3w_�}G���I��Q��:���N�>�1R�Y�˞���70�X���`�N�ů�-6�K!fv�*�"/x� �J�+@�޽1\ɹ?�}r�Z	c���@�;W��<�%2�����f�ĂXj|[A�/x ���Qs-�l�$��������~����m<w'��
|�����O�n��P�6�b��w�	K5O3V�J�˘��3��z���%A0�j����|�_�e㨈3��u��e��D�o�~[�˳nt�R"�����d�q5*��`��"-�#�ؓG^F�
4|L�l��N�
b���m�.҂�gF�IC�MC ���]B�Z3��:4iWY�KnJS��(�t^�G3�0~��Л��%A�M�\(�H ��/X��OP�a��e���X�K�h���ў� ez
�`0:��� H�6`ﲂ7��_�^v�q\����V�1b������kV�"�m�vVl(�"_�g��9�v��kݼ-x� �Ҳ�%k "�\܅m�Kxf�yS����X�K��N��
�S}p�lf�~:N�)�8�fo��?���%��Cf���	��cG���;�e�n�")x[��:ř ufN9���:?�`D�QZ�z����-�Ʋ����K~�&�(؁���Y�R�>Am�RA��^"�	�x�;�NhED�eG�oI�K�}������{�㛘f]�� ����P�/�|G
�$H�U���L�lh��
N*��-�[/1F��5+P�ۄߢ #!��Jx=i��]=���8�1�4S��s��H�`qR��c�d�XՁ�P��:�Il�u��$ȼ�Z��Kc9x8ۊ����J{[{�cN�7i��qW8��
0�:Cu�i�R���
�P�勴�M��k��*t�)~ι�$�"6az���ݼ,x� ��`P��`r+�M�����C;[C�n~��ɠ��v���i����t���W���d�/�}Kބ�a��%Pv��橭��.���@��6�e{��h��>6GG���}�9Rc��ct�4c�/���O�դ<@���XzS�'� G��{��=Z�&A���d���͕3�<���aM8T�ۻi�*q��	p�]��Aԟ�d�=��i]M���Fs-��c�d�N>�=u�-y	a&��Ը�X��e���m���Pos�l��mu�S8\�ޙ�77m
"�����	�~G	I �ZϷ,xHBԧb�ܗ��o�f~x�Ba�7R��ք��������B಑�$Z���Q�Ad��S�����؃N]��
� ��ҏfۈ��'�;OT�����U�����kRpg��� ���A�#�g�f���b��.�ߓ�#B�*���\ͺ(�¸& �3�5�K<�� ���tr��֕�o��$(��,5�ˤ�H �ߴD���csa�����é��Uk�l;� ?2��x!D�,��Ba���&��
X�}N�e���e�I��A�u�y�$�02�{�fq�V�eNp$ ��ꌣ�7ab3�C����oN=���ො���%@u}D*�ւ#<c�I� C�}�	���M�w�g��3�4S��z�ɶ~�����O:v�I:ΛA�^[uOeE���$��G n�zh�+�V������K�J�*'8��z:��#�;������0a�U���}���Z��Ữ4쪃Fr�Qb�n��L��	Үʛ��&����mv���{�j�����@�Π���_�����r�ψ۟b�(]���љ�P�'x rzax6�l<���Ķ�ƃ#�Y��A�-R�! g��>�
���	6!�#Bd�yq�3r��-R�.�7�S@�8��?bW30K@$AO    J ���9�_��	�'6+�s�/�� */,yq<&� ��m�/��	���Ȳ����*N:������<"��72�3s3�0����������ϘG��eO��X��Awn�50O���X��
���*� �Xx/��C��2<ѬP�gp����,'3!Z�V��~2�RʥNc����v��r�#H���~�|J�w�6��P(���� n���[�*���-V�!@�;�ח`f���`5+G/[�[�&]��U�.@��YZ88l��r��t��	�N�	f{��˩e��y�U�#�i�B�w�E�r0���Hq�w]d2 v*|-&�D����E�i��gq,�X�����q�Ħ��Ѧ��KC -as�(������h���{@�j���U�O�wU�. �^�,;
�G{"��;B-�%��\t�e�wi�� �Ӝ���i|u2Lf��`fJ�
@*�|@��M8G2Ƀ��ٮ����8h�]�Xs�	�iUQ�ɱVT�"��%k�uf�D창L�y��]b��T��m
�ԃ�HA�����`� �{�Lpw@`�|WĥvC]�������Y��Vp���#��0 ���$��&|0���اN���
�����Z�]��u|!��<&��ݥG �֟�6�6�B��,��	O���J��2Ys�	�O��CP�<y���&��)�qu#�2�*-8��gu�X�e�2äqR��Q�H�0ӵ���&Ƞe0��s� �L���GdHY�q_�)���,�w�.ΝnL� ����L+�ƽhd���ޅ�Vpd���5ƕ_�k�*��4�:f6pD�.��#A:�(�2�V�c�CX1������"�+���I �vZK�s�l�S�	3��xS�+7ab�|Y�`Z�n ��t�����2���e��^#(Q�ݫM|� 0���M��A3�<���\n�3b#��e�E���fK�m��m�zw��,3 ueMHj��j���jv�s���3��ĚlG!:�����	�s�,	��Ҥv�4�����[�`��$��O��\�iL��h9��S��A V�2h�A��� Č
�m��M��������#�۴`I���fT���(|�;��B|��Z�xh�Iu��nӂ%���
�$���Ѱ�ӄmr�i̾��uV ���,sh�(ӭNa^�q�W��#��f[�|�9�C:S�6�I��3Y�]uD��ʗ�gK >k.Sp��;�I�s�}�����#�8[X�eZ����3�Ea� ���L�!&�q��cw)Ѓ�,�FP/e�M;�N���#���Q��j��K8�"4Ba�{��9��&�?m�6��WhAdׄd�L�i@^ ,�ց�:v9�,� @w5��m�. �l?�z��n�"�hMx�����x�����.-8���>'�)r/�ն�q���9��r��i�!���ƀ�[�$gl-]Z@�l�ٛ#]�eZp$�In2��������G9����"NNgq�N!�ip#��'�]mA��L����&�]~����@
����N��aJy&�=$XVt|L��w��Ն�B�������%&�q��a3�X�	c�ˤ`K�*@G��[������=¶ȂQ�V#��}o�x���̎	��j �;f������m\|n�ȑsD=��YM��:�6�|���[Vp@�_QF�������[�G����%�u'��^e?�]��� ���MgfFx2�Fu-��c}/���^L�m�o7V �BJj�]�{��o�r3����P� �"t\},�6]�eVp$��#��Z�0�1<�����\c���/�����^a"1������Pb&7q�(���0g�;�]V� %�w��hO��)�Guh�����0�֓��Yp$�z^���,SN6ᦰ�4�;kB�#�y�����.F�����������@�'�����_&G9�Q����Sh����@5�W�dA|ν_fG����V���1����4����a����O,82�͐].�L���q�l1+�A�-�����U��|xߝv?Ҁe�Y��^�u�)G��C���)�_��#���Ve45�6�=�����ͪ�� Ⱦ�X�#����ӈ���qc��/
�m�_E���#A�u��E�:0�*B�������V��g�hO�T��6z,���v���,��#���# ��ɶR�86[V�3��,�Q�����g�s{�؜c�3ؾ�JFe���®�Zfj��
����!�B� ����BgH�g��ʙ�WK�d����n�cOl,�J�.Gp�#�AP���R�9}!Ã�����ϰ�<�I���kv ��4�*)��sﻊ1���CN�����A���&'�.��#��>PA�,�j���z����'�I�~����t�/a&�Ckt؃ʎ����|Fi�.�I����}
�)���_:;��c.�Z�,��+]&G� �9�"v���7Dǎ����쥤cP�¨�I��!�}_�*��c�,�vL���``#�r����?�H��_����'�e��E�ƞ��O�ڀ��Y���0G���ygMo8<� �"\��ך~���w� �O�O�,�,�<��=�7HI}��ﲂ	��p��}�,NZ�0W]` �2�<qܥ[ �ܱ�N��s]/��mT��kά޽K� P��l4�{a�r ,C���(~D?�\�g}	��(=��Υ����ʋ��/g#�h��i�{��;��������h���};�kZp$�,BZ�����8��/�� �D�Ѐ����Ϳ}�M5v�xLQ���.���R���>�w��'�_ND���@O��^3�3'�p0JQ^��EM��n��?0�{{��p'��Ew�C��i�v�)zw��D�se˙����7\��)��Ue��k�d/l܅��yǌK�}���N��J���MV��9�R:��9'be�-�Cg�ug�pwY�K���n}�'7^�׵|c�Wș�-�@s���?eA�f�JO�F�-����^2�'�Tn������S͙�*���x�[�xlVX�r��HnO˱l����"��2�I�\,x�n�N�*?$�r2>��.=M״�h���C�Ʉ�9{����vkE�������CC�57f��4�")�#�3��F,Gu���rs\h��6�\�Ax���xm��<�ya�����j�C�(����K�B-�dtv/+�o����ȹ��
S+nr�7	�n��������Pa��9Ne��CU�+�kN ���o���N��i�mYˌ��|ԯO�C�O�9�{��% �����ƛaf�%6THNM�4�$�")xI���\��ٮ��,Y���u%4 �8�綔y�����-�4C���(�Ć��pf���z��Ip�3�񭍽�S���^�[H[�؊�г���M ';62�ĩcm6�N�Kk��4�"��]�V�)�	������c��e;7J>��i�s{��	������ӥ�u�
 C C^ޱP\;b�����H��iGi��w��3�|����8�Łwu�
�vw߆�9��=&��!�#��9��V�_��:~H���
=b�(��9"W�s��ﱂw���@���]q�Y��9Q�?
�K���ao�3<>K���"6�d�h�{���YU�X���.���� H�?��F��gjqڽ��ޤ�2��$`�f��j����^��nN�)�|Ax� �|�� ,��px\�����v8>M���Z���5���X��� �k���xY�X�ұ��f�_^8Vެ�\��<ޭ�<~ݺ3j8������7	$��¼G)�h����bO�a�q�A�L~D�/G<�4|{&��@���@K�0!���+x� �k�7u4H`\&=4L�i`g�BW%�{�?$`ǜ%��*��v��b�NN#���_�d[���u[b+D#_0j*l?��*���!�lDHF[b���?#�/+()���1�� XΒ�V    Be����*_{=^�?�}���@���a*.E�n͑�&������$�GWZUgU(��9V���Am�T�c�� L� p��s0��n��"GVq~K�m�r�����3 ~1F�>�8A�2-�:{_�W��~ޯ��*����C?e5�I�\�|�6�M�t�N' [�7�k��
�g��0�qg�]^�#A6;ZJ3���+��#?�9��d(���6�������,gG�} ��B�\&`o=1�=t���65�M ���e�k��'�8��_tP���5lJ���Yw���Y}����<(�k��J��#���?�q*WM�x]UV�m�;���" kL]�0o�	�Qu�%2�fd^X��^E��@Y�e^p$�1�rt3���F�X	�� �@;��:/82�=����4�e�N�����S�E�����B�S&�g�䜠����t�0�Ĭ7�I`�H�mB�>X�b����	~�SxZ�U^pp,�_,5�XG����@��L���5�q�	�~��{�Yes��f�a�iY֛"̵^L8|[?�*�cnByLa��	�g���,^L,5����G�xƘN�����4&�ld�	�=嫴�O���&��)�P������ؽ��ly�!C�j���x�w�J�i�mp���i�� �ݸ����g�4^X��R����h�3��d?dzD�m��;N1�:�.�[��̂� E�><zV���tƆg�o�� B��A��L8|��d�J�v�
��ߝ8�n~D@���`�`�@�*����AT+�]Sc��Y��ӂ-��#T���	�G��f�R����8��f��0�]����8�Q�Zmp6�c��th��@�a�|� ��yCZ@-�׉�,����ߠ[��!��)0Nn"́Wl����6ܧK��[�P|��3o�$�o�g�On
���mZ��;��'�V�ګ��N�@���.�8��eZ�$�n��������,�� �z��`̡��^�k}|��4�|U��'HS���T��Ty��`���`��P��a+/Y�
&����\�a��_�{�]���cqJa�g�C é�� ]+~�>+X"��
65,}0�~�/Y f��6vh�N
� l�3�~�6ξL<~`G�C�8\�o�#�u�o�@+9}�+\Q`�Ӵ�q:WP��3�uwI��C�w�����$Y~��x��ӊ5����%G�S��Ktp�����q��D�<��7��?��Sc
�33?'��y({��{|i�6)8�ۑ�z�G 	��+����0Ef7�˹?X��<�X��5w�#N�m�$���P�}R�#C��P.m�@d�yGޚk`��f�/Wg)�N|�*/f���
���+Y����{S?%�;����0�3��,�^��z��5��.)8xsZ�� ����!�5�頨1Ll|�z�e��y�V b�g" ����ΣQI��<���*+8��.*���s~
ۏ-(��Q{�����O�>ݲa��Ҭ�u	��cC��:��n�G�X?�]�;]���ή�f+T�2�D(6h��ˍ��e�9��e�4��X#����f8y�	�r��2Y�"��< ܉�������W'b]��M��4�X`�SX��+���mM��8���%׆)���t���B�'+�����mh����wy����.B�h_Y� ���3lN.f�	�t�����f�9��_�͋���j�V���>���?����H0�Txy�z�l��p*�'����$8-�$���G\Y5q��:l*e��b���?2��{����5N�&;�rf�x�dsn%���!D��\�o2������+L4sd^*@�����G �V��hH�d����̴�)k6�b�w�~�������+|XO����s~$`�咀���qI�C��W��8]��/�2�#�����éz,[<X>>2)�>��i���nNCx@�F.є$�7�cfw;�>�� �)���'���v�SD��*~z��d�m����zV�]�-�����K�}i�T۶�V켷s�i����3o�?f��l6�<p/J@�v'���a�K���_���o�f�=����e�������؟l��������Ua{��,��X"���Ӽn�%�?-�l�����e�p�¢ь�����4�7�;��bE2�{Z�_�
��7�C�`�_�K�w���$���c9ՙeJ̹�τw�Z�嬸ۼ`I�����K2
��<��&�>�F�1����^@Ԅ���Ħ��]��O)��T�mg!�rۂ7!$�D�:87�oX��\��4���z��ћz�Ӽ���>#3y0ln�\C3��c��F'~`&6�=�KG��8?��:ڨ��YH~��G �6(���p�#s|����A zH.��%s�,8H{�eo}j�(���4h�1�0<�Jq�i� �[|���'4� ����Wg}[l���]Z��n�	���Q� YTu>��u2!�1���_�K��X��Ju�v�5a[�)�����~�l	B�u�����jy%���W�K$=ʥ�+����\�����')h!۝z��Į{DL��u� �����f�e�u�<֤d�60zM�L{�L���X]6�å��1M��n����ӫa~�]ZpD�n���Լ#�D]Y��c1���'<o�+�9�%�v���| �(+c���r�x�K;+�}^�?�݃~�f7T&�!Fu�F�8�e a<.^�GI'�f�T�!=�s�Р{v:�h{������a_���RX��'����jQA���^�G{2/%vv�qO�eEIG�ƫ��Q`p�wi��ɾ��ϒ���1���,��.ӂ�~�15�>`\�>���g�?�3?���҂#��;	�Eϔ��������t���޲��.-8���SŲ{��9����8f������T�UZp֏ƟZ�
��c�o�M@2���ۅ�$Y��oӂv�]>!�����c��qI�#b
�|�]Vp �\1�d��zLd�.�Ϯl8#���;��SX ��S%��������QX������MV�>�t� ����3Sǌ'^�Jk@��n63z��'���t�ɹ��Av0�c%؀���iW��ύ�a����逩5I#
%8?��e�eVp$H��v�ȠZ+O���x̪�=7�.����%c��-A�U�	�2N��؂ۤ�ȐugX8㣗�����M�l�-|f���|��ѻ�(L�%�<����X�
�g�C�ܷ�H�~�q�g��Q��+pl�J�G��[�&�%?�y��2�_��vHf�i�GLA�G��.�!�H ���Vjkl,��}�9rCi����C��`M�:�?�<�,P��݄����qn�ﲂ�iz
���t"�>prT�s#1���*+8�R2�xI�Vk9Q��򼰙�	���;/�o���SHYs9p�kd[�4xu�}�1-�vs�����j���`E�y�����1�+)�X��B�g8��&$�~f��v|�.�8T�nׂ����\>"3L���:��X��������ѽM
�п]��Ҡ�l]5IKLgM�)M_��c�N
�)��偠�%k�8�(�:���V �mR@	��4ĘȂ\|����f�����a/W'�H �<����Ў}珳�d
�$�;�f�ﳂ%��;뱔bS�U���,tE50�CIcw��/C��쓭� eX�\}f#�Oك���Cl�w�,	���Q�jܨ�\�9H��I$�g����nNN| H�?bGq6G��F���K�͇h���%A�;R�	��&��wuˁ֬ɘ�omִZn��%@�;��.  �s��C��@!g�`�Y�򻍎��M�/tXZ�x)���}�Z����������:N��%�Jr_�+�)KB��7X����͎`'���d���+���%����`I�39����n������k@6    ���=+��F~� 6��R��B���3�mt
��������3�^d�]������M"be�Ay����&�^-DxI�'�2�s�K3k�A3���m��G�[������uڹ�����R��ٰR���99�M��f���h9�ޔ� &|Ҷ��
�����Ip^BJ}��v�7��:BSr�40(����%��������ְ*6}�.�g��i���\�/!"�XQD�U�"�ٍa<�y�v�I^�
{�f����M�{��؀���m�8�{��%@��)u��aZnN���\;}�a^}B��@�	����'N�����d+��qA@$�%�.҂� �).�[�yY��� I�p�{	�7�_�yƙ2
�!v���Q��~У`g���G����BKmŪ�EA(\9�}(����ۙ/��Z �S����v�Ɔ�X�nP��#��^����ì��u-���VT�Ai�PÅ7��.�����y�l�Y�n�ΰ�����(��y3����VϜ6o���� �>zu��+*��\b�!^gK �{ �U����3vg����x��zn�gKw�Z¬p���8>���Z������g\M7|� `bO���0���3oC�������/	�)���̉/_8����R��d��,�nfR�y�̬{K�ZO��4BH��`[����ݬS�Ή�!��O#WR;���`I�C
��������3ȓ��|*�Z�9P�m�t�\�B�����*���ߍ����t�7	�x���N�i%ɬ�<6s��5[>�p�,r�C�3'R$[�z��3,<X�#�	%є��mR@�|퀗�c���{u�����f�՞�a����� �
	�άP���|�,9�V��D��`ː�1�5�w<��G{��0��,B�~���%���`n�x�x�W����n��`��r���p>8�S*r)��X7S��Z������V/��- ��tܭ-�	#h|��4u|���@����N۔���ʼ��
��T�n�F��[�����s���0����ׁ�
g�bD�2+8���L�i�r�zc[#2(�sv�/5��x���K��ӽ�N���L;E�؞	?�����].Bx�u�xU�\9'�MYsl�3�{&�0ŖQ�}V�#Dޏj8�>K)�8*'��&s�M�)w�	8�oтma��>��eͯʑ�@嫴����L2sJ�@�6����AGO�o�N|I +�N�{N}�����9A{!H��VJ$�L,x���*<}x��Dc�F��:0}BѤ�b�҂#��O�J��Z|���\�uv���Ā��*+�Y>����p���O��L7��i�D����3/78|ɠn��3�Ag;X�`F�l���h��щo�=�˺�߃Q��Z.K0�g��8�HL���I�$#�3���-P6Y6��	�OM|@k�#6�J�J
� ޝ���+��30�햜4=A"|[�廂	��c�\���J9���oE����G��ˬ�G�pzO��Bz���y��!,�Ph�zsv�Q�������eT �9��h���z��� �1�����>�[v��!ꙕ�̧m�]�Axɐ�.Nº�<�:��qe�8mѪ���]����*��9�X�a� Ҁ,{�o�ts����tvcJ��i��lOǎJe����p�q\eG�`��K	18B]#�YD�2&�9p��x��H�ӄ���6��`a�0�y���B�0<�,�*+�@�@�Y���y��NOt��́=P8l4���t× �l��f�@ +5�Kܜ��
��r.�&����<��F���Wa��iͥ
/J����%�;�VA{�������B _?Ӛ,�	h��]Z�#�7��@D�I�kz�c~Ix�J;��,�������GD�3��'�Vc��xʢU�FI?9�̈́������&� .�����X��wF��3�"/xI iR�lIa�
(��Y�졍"31����ė ��5�D)� >XR�~�:��iM���Մ×���y�OI #�k�'�q�0�i�ٻ�o�3**;3���,M+M׈���
8M{��dpg6����E�}�o�>��C#CI���6/x�(>4�MO���sRg*��U��v����M�,�e��a�+Jb�o��vssL�K ow�������!� ČxmU��Mg��Y�&A��'>�}<�3hZ�i�����f�� A��Ibҽq8��֯�C4���F�
��~sLқ ?eA�&7# �-͜'=5	�?��֦��^�;�~�R��\�O���g�H�P�՜ay��ћn�wT0d[`�a3�.�NQ4$N�����$8i�5ƴ�J��r��V�l��p�~@.���u�'�HP'!prg8�&��)R5tћ�����i�G���u�'�D���s�y�G	Os��$oOz�`�����l�g&���5@'A���!�D��SZ�a(��;��,G�f>�
'熿N��4��	�0�m���{�pZA�p��mZ�%��=���?���A���E_Y���Z�d���y�i3pe"2Ε�H�i��|*�n?"�	�~\w_�B�hfVB��cԴ��-��N�AOC'L�	y��a�����[�x�#XWn�Cx ��O�-' *b�߬ e��i�̆��[� ��!`7'f����l/�d4���uZ��;ZA��7��N�T��:���r38�۴`��dm�BH��q7=<���[��p��]V���y@���ci��+�$ ���#-��z�PϤ�3��C���ꊘ������I�}^M-x� �Q����3������۳X��8�z���� 6;6���?lu�7|�*;�U�T!|����
��Ѥ�q�(P$Gu�n^O-pd��*�� �Gv����B4;1���x�F8���mo�A�~Ab�{d#�Ir��?T�5��G������=���A��/'4ov�)S������!W�!�I7 ;v��E1�m;:���TS��lAy����>m��TfX^�1���٤�Xs�e�����/L� :_�ǨD�,�R�f�$8�&ss���J ��f'���D7�J�r��>,q�_ՠ01��s|*g�9���2��˜�G��6���4>�Ǖ�U�xN���W: �f�� 0��٬#hF`���p�w��Kf�T#7�^$���R����:��끝dX3k�54S�ݫ���w+-횴s�oe��&������n�f~�mNpD�v����N�;�`{a�Og�1xa7�jǂ? :��*B��F6!Pa���Oر�V�F0���X7����v��>�0bV�b
s�eل܀��.)�X�ݰC3<pH�.(؅�-|Ro`c�s���$��	�Jl�E����H�� �b��ք۬��t�����
l;}*Dh�D�xl�7;��t��H�w�w�0���<�Jزa�ţ�YMW�!�$��-E�i��
�Rsk:߲�~{��Zf�[��
����<X�A��M�+�I�+ρ	��3b����.�	�4����ZZ�W���Z�����G����*'(��'|\R�o�"�Yo�&��^��)s.�靷W�E�hY���6/ӂ#���j���5O,��W��8%�􀝎��~�s���v���j#��X�A�l�Xp�Y�ok����%�Z��	i���f�����ѐm,^�ƻw?�]-�*N�}[�gU/�*[\N?�
>]�M|�`�~J��{ဖ�Y&�/��s�5��W�'�$Xo�t܎��r���+q�k,�|wxA���+��w|T�� ������L�A�s�c�͌�?@qvQ�+\����4xz�8�-�߾-�� b���z��✨l��'Ӡ�/H�n��K8ҥkh�g�3�O�<杈ɳ�p��jNt���C�g���VF�	�j����̂	�`j���-���N��s�i~���?.�!�d��� [6!f{@�-|
����` �{���  �  �[�<��K���L�="%čU�4c���Yp$���Rqϔ��y�À0�`lu��(�.-�Y?��i��JN~*�Ӭ���<	�eZp$pqWGM[^A�]��J�(*���Po�,x	��D�R8T���)�)�-B9��t�5o�.-� ��b*|�e��j��WoA����#O�_�݉��4�=�u�Ab��6�Z�.'������ B�˭vJ8���<;/���_��'��jC���QF��r6�m�H3ޢ�sB�)���6�V(����43N`����� "g|��H�<YA�LX��E�j�Y�@әZig�>�O�2	���Y�p&؅b��Bx� �${+8X�x�;�C*L���*q�W{�,	���\-s����#g=#)����\rㆁ ��]��?gɆ?��y%qkzg���FdWW�]l��e5۷�=�� =�3l-Wl
V]�`�H��8{i��{n?�
n�=#�4gFR
�I
+|d��* ����~@��Ng�>g2����O�k��}����D=�*�D����D}�A�� H���܆r���6�Z�P�}�kj����URNe��i�Ymnuw��B�ܚ"B>@�����U'M�gM�3PnA2o����g�.g��сU}6Ě�oc�����a���=�Ns���8����Z2A�UQ�Y<��ٶ=�������y{��y���V�`�̂�]N�e�6��ԐǉDmA��qBm�*x�1�bx��j�M����j�x��3!�����F�᷃����.h�n�9)ʗfBŪ�#�~�J
Hq�(��\��[�,q9R�������4t�T�\������� ����
�ɪ�T����=~�"�2����O� �e�f��*KrD��-MG���2%�Vߥ
��c�H�>�W=\��<��[��*�6U�B�W�/���^��/En�j(_"[ĝ��FU�ƐU�Ǚ��Р3"\L��ӳ���%�v����	�$�g��<o�Q���/bf�(��6U�9�i�B�����pw�\}� ��)�7��K� X���w�9�Qq����"T��r罛R���7��L�k:;��c=�tKDj��)��M|�]����e��
���Lp�oȳ���ڴ���(v�� g�I}����@*(͌r m^�X�w�������|��uY^�IU?�">�@��.�;o!�1��[�/R,GP��u�Ntݒ�r�L��B��؄?�����E��         +  x����R�J���Sx�բ���Il0@�0T6=	���>�m���lX�*��*�U�����mT�[,��X���.�(R*1B	�s�C�ղ��i��ls�O
�,�3D�U�Hm4��Qe�����r\���a��e��`b0S(o����v1���q�,{�G��:NN��%���C���yzt3=X�LN����D?��Y2�s,X�����bZР��N&�O��8Xon	A����<qgD�#L`"1�J�R4�ʨ��{���Mn�\g�(!:���K�*�����":\$S���,���U�S/��j�;KivW�, �QCФ¾�Õej��(�E��h\�/�4[�P��>�E9��O���r.n��հ��/[�-Z웃No���t���ay���aFn�WvOc���N+D���#�}��M�3b`�?oMI3M�T���K�`�����G�x,p�r�Zh�Nݼt�]��M7�"b$��I���B�J�Tm=\����Ot��s�.����j�M�>:�?�����s>�ݟ�x)��v�_��ɼ�Yt�.���0���{����[�g���UM"�Ded�B�E�`�o��9�*��ƈ�c6�6iɵ��P	�s�vQ/��gWeX�UF%�&��|��d�^6����j�њ�PĢ���d��ꆫ�!T���j�mp�{����������Ow��7]��:M����P��U�����`�K^1B�mª 0:��������l��(C'�����?��T�q_Xic����U��4��<�0a�2��{�Bɗ��m�ܞ��;����u�Xu[ȳ���S^���jM��kw�۟,D�d0�,�!t	S�`j�4�y
�mkOeZSc?6"m
�2��N*����}��R��H�xÑ{aD��V����S�����|���߱�U���C8��D�4��Z��8�ѧ����|��9�,<߿�_�5]���L�|��I�N�y\�pY`_(�It>"�$�{��0�lӂ�`9g�0А�7f{{{� Q-�     