PGDMP       $                }            YouEvent    17.2    17.2 9    @           0    0    ENCODING    ENCODING        SET client_encoding = 'UTF8';
                           false            A           0    0 
   STDSTRINGS 
   STDSTRINGS     (   SET standard_conforming_strings = 'on';
                           false            B           0    0 
   SEARCHPATH 
   SEARCHPATH     8   SELECT pg_catalog.set_config('search_path', '', false);
                           false            C           1262    16615    YouEvent    DATABASE     �   CREATE DATABASE "YouEvent" WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'English_United States.1252';
    DROP DATABASE "YouEvent";
                     postgres    false            z           1247    16943    capacitestatus    TYPE     M   CREATE TYPE public.capacitestatus AS ENUM (
    'Disponible',
    'Vendu'
);
 !   DROP TYPE public.capacitestatus;
       public               postgres    false            h           1247    16843    statusevenement    TYPE     ^   CREATE TYPE public.statusevenement AS ENUM (
    'actif',
    'en attente',
    'terminé'
);
 "   DROP TYPE public.statusevenement;
       public               postgres    false            t           1247    16898    statusreservation    TYPE     O   CREATE TYPE public.statusreservation AS ENUM (
    'valider',
    'annuler'
);
 $   DROP TYPE public.statusreservation;
       public               postgres    false            n           1247    16876 
   tickettype    TYPE     d   CREATE TYPE public.tickettype AS ENUM (
    'gratuit',
    'payant',
    'VIP',
    'early bird'
);
    DROP TYPE public.tickettype;
       public               postgres    false            �            1259    16803    users    TABLE     �   CREATE TABLE public.users (
    iduser integer NOT NULL,
    username character varying(255) NOT NULL,
    email character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    image text,
    phone character varying(20)
);
    DROP TABLE public.users;
       public         heap r       postgres    false            �            1259    16827    admin    TABLE     7   CREATE TABLE public.admin (
)
INHERITS (public.users);
    DROP TABLE public.admin;
       public         heap r       postgres    false    218            �            1259    16834    category    TABLE     l   CREATE TABLE public.category (
    idcategory integer NOT NULL,
    name character varying(255) NOT NULL
);
    DROP TABLE public.category;
       public         heap r       postgres    false            �            1259    16833    category_idcategory_seq    SEQUENCE     �   CREATE SEQUENCE public.category_idcategory_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 .   DROP SEQUENCE public.category_idcategory_seq;
       public               postgres    false    223            D           0    0    category_idcategory_seq    SEQUENCE OWNED BY     S   ALTER SEQUENCE public.category_idcategory_seq OWNED BY public.category.idcategory;
          public               postgres    false    222            �            1259    16856 	   evenement    TABLE     d  CREATE TABLE public.evenement (
    idevent integer NOT NULL,
    titre character varying(255) NOT NULL,
    intro text,
    description text,
    date date NOT NULL,
    status public.statusevenement DEFAULT 'en attente'::public.statusevenement,
    lieu character varying(255),
    capacite integer,
    idcategory integer,
    idorganisateur integer
);
    DROP TABLE public.evenement;
       public         heap r       postgres    false    872    872            �            1259    16855    evenement_idevent_seq    SEQUENCE     �   CREATE SEQUENCE public.evenement_idevent_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 ,   DROP SEQUENCE public.evenement_idevent_seq;
       public               postgres    false    225            E           0    0    evenement_idevent_seq    SEQUENCE OWNED BY     O   ALTER SEQUENCE public.evenement_idevent_seq OWNED BY public.evenement.idevent;
          public               postgres    false    224            �            1259    16819    organisateur    TABLE     Y   CREATE TABLE public.organisateur (
    evenements_crees jsonb
)
INHERITS (public.users);
     DROP TABLE public.organisateur;
       public         heap r       postgres    false    218            �            1259    16813    participant    TABLE     X   CREATE TABLE public.participant (
    billets_reserves jsonb
)
INHERITS (public.users);
    DROP TABLE public.participant;
       public         heap r       postgres    false    218            �            1259    16921    reservation    TABLE     �   CREATE TABLE public.reservation (
    iduser integer,
    idevent integer,
    idticket integer,
    date date NOT NULL,
    prix_paye double precision,
    status public.statusreservation DEFAULT 'valider'::public.statusreservation,
    qrcode text
);
    DROP TABLE public.reservation;
       public         heap r       postgres    false    884    884            �            1259    16886    ticket    TABLE     �   CREATE TABLE public.ticket (
    idticket integer NOT NULL,
    idevent integer,
    type public.tickettype,
    capacite public.capacitestatus,
    prix double precision
);
    DROP TABLE public.ticket;
       public         heap r       postgres    false    878    890            �            1259    16885    ticket_idticket_seq    SEQUENCE     �   CREATE SEQUENCE public.ticket_idticket_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 *   DROP SEQUENCE public.ticket_idticket_seq;
       public               postgres    false    227            F           0    0    ticket_idticket_seq    SEQUENCE OWNED BY     K   ALTER SEQUENCE public.ticket_idticket_seq OWNED BY public.ticket.idticket;
          public               postgres    false    226            �            1259    16802    users_iduser_seq    SEQUENCE     �   CREATE SEQUENCE public.users_iduser_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;
 '   DROP SEQUENCE public.users_iduser_seq;
       public               postgres    false    218            G           0    0    users_iduser_seq    SEQUENCE OWNED BY     E   ALTER SEQUENCE public.users_iduser_seq OWNED BY public.users.iduser;
          public               postgres    false    217            �           2604    16830    admin iduser    DEFAULT     l   ALTER TABLE ONLY public.admin ALTER COLUMN iduser SET DEFAULT nextval('public.users_iduser_seq'::regclass);
 ;   ALTER TABLE public.admin ALTER COLUMN iduser DROP DEFAULT;
       public               postgres    false    221    217            �           2604    16837    category idcategory    DEFAULT     z   ALTER TABLE ONLY public.category ALTER COLUMN idcategory SET DEFAULT nextval('public.category_idcategory_seq'::regclass);
 B   ALTER TABLE public.category ALTER COLUMN idcategory DROP DEFAULT;
       public               postgres    false    223    222    223            �           2604    16859    evenement idevent    DEFAULT     v   ALTER TABLE ONLY public.evenement ALTER COLUMN idevent SET DEFAULT nextval('public.evenement_idevent_seq'::regclass);
 @   ALTER TABLE public.evenement ALTER COLUMN idevent DROP DEFAULT;
       public               postgres    false    225    224    225            �           2604    16822    organisateur iduser    DEFAULT     s   ALTER TABLE ONLY public.organisateur ALTER COLUMN iduser SET DEFAULT nextval('public.users_iduser_seq'::regclass);
 B   ALTER TABLE public.organisateur ALTER COLUMN iduser DROP DEFAULT;
       public               postgres    false    220    217            �           2604    16816    participant iduser    DEFAULT     r   ALTER TABLE ONLY public.participant ALTER COLUMN iduser SET DEFAULT nextval('public.users_iduser_seq'::regclass);
 A   ALTER TABLE public.participant ALTER COLUMN iduser DROP DEFAULT;
       public               postgres    false    217    219            �           2604    16889    ticket idticket    DEFAULT     r   ALTER TABLE ONLY public.ticket ALTER COLUMN idticket SET DEFAULT nextval('public.ticket_idticket_seq'::regclass);
 >   ALTER TABLE public.ticket ALTER COLUMN idticket DROP DEFAULT;
       public               postgres    false    226    227    227            �           2604    16806    users iduser    DEFAULT     l   ALTER TABLE ONLY public.users ALTER COLUMN iduser SET DEFAULT nextval('public.users_iduser_seq'::regclass);
 ;   ALTER TABLE public.users ALTER COLUMN iduser DROP DEFAULT;
       public               postgres    false    218    217    218            6          0    16827    admin 
   TABLE DATA           P   COPY public.admin (iduser, username, email, password, image, phone) FROM stdin;
    public               postgres    false    221   �C       8          0    16834    category 
   TABLE DATA           4   COPY public.category (idcategory, name) FROM stdin;
    public               postgres    false    223   �C       :          0    16856 	   evenement 
   TABLE DATA           �   COPY public.evenement (idevent, titre, intro, description, date, status, lieu, capacite, idcategory, idorganisateur) FROM stdin;
    public               postgres    false    225   �C       5          0    16819    organisateur 
   TABLE DATA           i   COPY public.organisateur (iduser, username, email, password, image, phone, evenements_crees) FROM stdin;
    public               postgres    false    220   �C       4          0    16813    participant 
   TABLE DATA           h   COPY public.participant (iduser, username, email, password, image, phone, billets_reserves) FROM stdin;
    public               postgres    false    219   D       =          0    16921    reservation 
   TABLE DATA           a   COPY public.reservation (iduser, idevent, idticket, date, prix_paye, status, qrcode) FROM stdin;
    public               postgres    false    228   D       <          0    16886    ticket 
   TABLE DATA           I   COPY public.ticket (idticket, idevent, type, capacite, prix) FROM stdin;
    public               postgres    false    227   <D       3          0    16803    users 
   TABLE DATA           P   COPY public.users (iduser, username, email, password, image, phone) FROM stdin;
    public               postgres    false    218   YD       H           0    0    category_idcategory_seq    SEQUENCE SET     F   SELECT pg_catalog.setval('public.category_idcategory_seq', 1, false);
          public               postgres    false    222            I           0    0    evenement_idevent_seq    SEQUENCE SET     D   SELECT pg_catalog.setval('public.evenement_idevent_seq', 1, false);
          public               postgres    false    224            J           0    0    ticket_idticket_seq    SEQUENCE SET     B   SELECT pg_catalog.setval('public.ticket_idticket_seq', 1, false);
          public               postgres    false    226            K           0    0    users_iduser_seq    SEQUENCE SET     ?   SELECT pg_catalog.setval('public.users_iduser_seq', 1, false);
          public               postgres    false    217            �           2606    16841    category category_name_key 
   CONSTRAINT     U   ALTER TABLE ONLY public.category
    ADD CONSTRAINT category_name_key UNIQUE (name);
 D   ALTER TABLE ONLY public.category DROP CONSTRAINT category_name_key;
       public                 postgres    false    223            �           2606    16839    category category_pkey 
   CONSTRAINT     \   ALTER TABLE ONLY public.category
    ADD CONSTRAINT category_pkey PRIMARY KEY (idcategory);
 @   ALTER TABLE ONLY public.category DROP CONSTRAINT category_pkey;
       public                 postgres    false    223            �           2606    16864    evenement evenement_pkey 
   CONSTRAINT     [   ALTER TABLE ONLY public.evenement
    ADD CONSTRAINT evenement_pkey PRIMARY KEY (idevent);
 B   ALTER TABLE ONLY public.evenement DROP CONSTRAINT evenement_pkey;
       public                 postgres    false    225            �           2606    16826     organisateur organisateur_unique 
   CONSTRAINT     ]   ALTER TABLE ONLY public.organisateur
    ADD CONSTRAINT organisateur_unique UNIQUE (iduser);
 J   ALTER TABLE ONLY public.organisateur DROP CONSTRAINT organisateur_unique;
       public                 postgres    false    220            �           2606    16920 %   participant participant_iduser_unique 
   CONSTRAINT     b   ALTER TABLE ONLY public.participant
    ADD CONSTRAINT participant_iduser_unique UNIQUE (iduser);
 O   ALTER TABLE ONLY public.participant DROP CONSTRAINT participant_iduser_unique;
       public                 postgres    false    219            �           2606    16891    ticket ticket_pkey 
   CONSTRAINT     V   ALTER TABLE ONLY public.ticket
    ADD CONSTRAINT ticket_pkey PRIMARY KEY (idticket);
 <   ALTER TABLE ONLY public.ticket DROP CONSTRAINT ticket_pkey;
       public                 postgres    false    227            �           2606    16812    users users_email_key 
   CONSTRAINT     Q   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_key UNIQUE (email);
 ?   ALTER TABLE ONLY public.users DROP CONSTRAINT users_email_key;
       public                 postgres    false    218            �           2606    16810    users users_pkey 
   CONSTRAINT     R   ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (iduser);
 :   ALTER TABLE ONLY public.users DROP CONSTRAINT users_pkey;
       public                 postgres    false    218            �           2606    16865 #   evenement evenement_idcategory_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.evenement
    ADD CONSTRAINT evenement_idcategory_fkey FOREIGN KEY (idcategory) REFERENCES public.category(idcategory) ON DELETE SET NULL;
 M   ALTER TABLE ONLY public.evenement DROP CONSTRAINT evenement_idcategory_fkey;
       public               postgres    false    4758    225    223            �           2606    16870 '   evenement evenement_idorganisateur_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.evenement
    ADD CONSTRAINT evenement_idorganisateur_fkey FOREIGN KEY (idorganisateur) REFERENCES public.organisateur(iduser) ON DELETE SET NULL;
 Q   ALTER TABLE ONLY public.evenement DROP CONSTRAINT evenement_idorganisateur_fkey;
       public               postgres    false    225    4754    220            �           2606    16932 $   reservation reservation_idevent_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.reservation
    ADD CONSTRAINT reservation_idevent_fkey FOREIGN KEY (idevent) REFERENCES public.evenement(idevent) ON DELETE CASCADE;
 N   ALTER TABLE ONLY public.reservation DROP CONSTRAINT reservation_idevent_fkey;
       public               postgres    false    4760    228    225            �           2606    16937 %   reservation reservation_idticket_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.reservation
    ADD CONSTRAINT reservation_idticket_fkey FOREIGN KEY (idticket) REFERENCES public.ticket(idticket) ON DELETE CASCADE;
 O   ALTER TABLE ONLY public.reservation DROP CONSTRAINT reservation_idticket_fkey;
       public               postgres    false    227    228    4762            �           2606    16927 #   reservation reservation_iduser_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.reservation
    ADD CONSTRAINT reservation_iduser_fkey FOREIGN KEY (iduser) REFERENCES public.participant(iduser) ON DELETE CASCADE;
 M   ALTER TABLE ONLY public.reservation DROP CONSTRAINT reservation_iduser_fkey;
       public               postgres    false    219    4752    228            �           2606    16892    ticket ticket_idevent_fkey    FK CONSTRAINT     �   ALTER TABLE ONLY public.ticket
    ADD CONSTRAINT ticket_idevent_fkey FOREIGN KEY (idevent) REFERENCES public.evenement(idevent) ON DELETE CASCADE;
 D   ALTER TABLE ONLY public.ticket DROP CONSTRAINT ticket_idevent_fkey;
       public               postgres    false    225    227    4760            6      x������ � �      8      x������ � �      :      x������ � �      5      x������ � �      4      x������ � �      =      x������ � �      <      x������ � �      3      x������ � �     